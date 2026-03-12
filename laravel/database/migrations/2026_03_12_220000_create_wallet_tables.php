<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_library_identifier')->unique();
            $table->string('push_token');
            $table->timestamps();
        });

        Schema::create('wallet_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_device_id')->constrained('wallet_devices')->cascadeOnDelete();
            $table->string('pass_type_identifier');
            $table->string('serial_number'); // CrmContact UUID
            $table->timestamps();

            $table->unique(
                ['wallet_device_id', 'pass_type_identifier', 'serial_number'],
                'wallet_reg_unique'
            );
            $table->index(['pass_type_identifier', 'serial_number']);
        });

        Schema::create('wallet_pass_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('label_primary')->default('VOS POINTS');
            $table->string('label_secondary')->default('CLIENT');
            $table->string('foreground_color')->default('#FFFFFF');
            $table->string('background_color')->default('#282828');
            $table->string('label_color')->nullable();
            $table->string('logo_text')->nullable();
            $table->string('icon_path')->nullable();
            $table->string('icon_2x_path')->nullable();
            $table->string('logo_image_path')->nullable();
            $table->string('logo_2x_path')->nullable();
            $table->string('strip_path')->nullable();
            $table->string('strip_2x_path')->nullable();
            $table->timestamps();
        });

        // Add wallet_auth_token to crm_contacts
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->string('wallet_auth_token', 32)->nullable()->unique()->after('pass_token');
        });
    }

    public function down(): void
    {
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropColumn('wallet_auth_token');
        });

        Schema::dropIfExists('wallet_registrations');
        Schema::dropIfExists('wallet_devices');
        Schema::dropIfExists('wallet_pass_settings');
    }
};
