<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'influencer'])->default('influencer')->after('email');
            $table->decimal('commission_percent', 5, 2)->nullable()->after('role');
            $table->decimal('discount_percent', 5, 2)->nullable()->after('commission_percent');
            $table->string('referral_code')->unique()->nullable()->after('discount_percent');
            $table->boolean('is_active')->default(true)->after('referral_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'commission_percent', 'discount_percent', 'referral_code', 'is_active']);
        });
    }
};



