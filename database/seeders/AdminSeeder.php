<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $admin = User::where('email', 'admin@universalgold.com')->first();
        
        if (!$admin) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@universalgold.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]);
            echo "Usuario administrador creado exitosamente.\n";
        } else {
            // Update password in case it was changed
            $admin->update([
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]);
            echo "Usuario administrador actualizado (contraseña restablecida a 'password').\n";
        }
    }
}


