<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    public function show($code)
    {
        $influencer = User::where('referral_code', $code)->where('role', 'influencer')->where('is_active', true)->firstOrFail();
        
        return view('landing.register', [
            'influencer' => $influencer,
            'referral_code' => $code,
        ]);
    }

    public function register(Request $request, $code)
    {
        $influencer = User::where('referral_code', $code)->where('role', 'influencer')->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'phone.required' => 'El WhatsApp es obligatorio.',
            'phone.string' => 'El WhatsApp debe ser texto.',
            'phone.max' => 'El WhatsApp no puede tener más de 20 caracteres.',
        ]);

        // Create lead
        $lead = Lead::create([
            'user_id' => $influencer->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => 'pending',
        ]);

        // Generate unique coupon code
        $couponCode = strtoupper(Str::random(8));
        
        // Ensure directory exists
        if (!Storage::disk('public')->exists('coupons')) {
            Storage::disk('public')->makeDirectory('coupons');
        }
        
        // Generate QR code as PNG with logo
        $qrPath = 'coupons/qr_' . $couponCode . '.png';
        $this->generateQrWithLogo($couponCode, $qrPath, $influencer->discount_percent ?? 10);

        // Create coupon
        $coupon = Coupon::create([
            'lead_id' => $lead->id,
            'code' => $couponCode,
            'qr_path' => $qrPath,
            'status' => 'active',
        ]);

        return view('landing.success', [
            'coupon' => $coupon,
            'influencer' => $influencer,
        ]);
    }

    private function generateQrWithLogo($code, $qrPath, $discountPercent = 10)
    {
        $qrSize = 300;
        $margin = 30;
        $textHeight = 60;
        
        // Generate QR code using external API (returns PNG directly)
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize}x{$qrSize}&data=" . urlencode($code);
        $qrPngContent = @file_get_contents($qrUrl);
        
        if ($qrPngContent === false) {
            // Fallback: Generate as SVG
            $qrSvg = QrCode::format('svg')->size($qrSize)->generate($code);
            $svgPath = str_replace('.png', '.svg', $qrPath);
            Storage::disk('public')->put($svgPath, $qrSvg);
            return;
        }
        
        $qrResource = imagecreatefromstring($qrPngContent);
        
        // Create final image with margins and text area
        $finalWidth = $qrSize + ($margin * 2);
        $finalHeight = $qrSize + ($margin * 2) + $textHeight;
        $finalImage = imagecreatetruecolor($finalWidth, $finalHeight);
        
        // Colors
        $white = imagecolorallocate($finalImage, 255, 255, 255);
        $black = imagecolorallocate($finalImage, 0, 0, 0);
        $green = imagecolorallocate($finalImage, 30, 81, 40); // #1e5128
        $gold = imagecolorallocate($finalImage, 188, 147, 19); // #bc9313
        
        // Fill with white
        imagefill($finalImage, 0, 0, $white);
        
        // Copy QR code to center with margin
        imagecopyresampled($finalImage, $qrResource, $margin, $margin, 0, 0, $qrSize, $qrSize, imagesx($qrResource), imagesy($qrResource));
        
        // Add "Universal Gold" text at the top
        $brandText = "Universal Gold";
        $brandFontSize = 5;
        $brandTextWidth = strlen($brandText) * imagefontwidth($brandFontSize);
        $brandX = ($finalWidth - $brandTextWidth) / 2;
        imagestring($finalImage, $brandFontSize, $brandX, 10, $brandText, $green);
        
        // Add code text at the bottom
        $codeText = "Codigo: " . $code;
        $codeFontSize = 4;
        $codeTextWidth = strlen($codeText) * imagefontwidth($codeFontSize);
        $codeX = ($finalWidth - $codeTextWidth) / 2;
        $codeY = $qrSize + ($margin * 2) + 15;
        imagestring($finalImage, $codeFontSize, $codeX, $codeY, $codeText, $black);
        
        // Add decorative line
        imageline($finalImage, $margin, $qrSize + ($margin * 2) + 5, $finalWidth - $margin, $qrSize + ($margin * 2) + 5, $gold);
        
        // Save image
        ob_start();
        imagepng($finalImage);
        $imageData = ob_get_contents();
        ob_end_clean();
        
        Storage::disk('public')->put($qrPath, $imageData);
        
        imagedestroy($finalImage);
        imagedestroy($qrResource);
    }

    public function downloadQr($code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();
        
        if (!$coupon->qr_path || !Storage::disk('public')->exists($coupon->qr_path)) {
            abort(404, 'QR no encontrado');
        }
        
        $filePath = Storage::disk('public')->path($coupon->qr_path);
        $fileName = 'cupon-universal-gold-' . $coupon->code . '.png';
        
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'image/png',
        ]);
    }
}

