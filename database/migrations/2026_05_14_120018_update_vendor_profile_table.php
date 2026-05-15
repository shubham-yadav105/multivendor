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
        Schema::table('vendor_profiles', function (Blueprint $table) {
            // Contact
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->default('India');

            // Business
            $table->enum('business_type', ['individual', 'company'])->default('individual');
            $table->string('gst_number')->nullable();
            $table->string('shop_category')->nullable();

            // Bank
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_name')->nullable();

            // Identity
            $table->string('id_type')->nullable(); // aadhar, pan, passport
            $table->string('id_number')->nullable();
            $table->string('id_document')->nullable(); // file path

            // Onboarding
            $table->integer('onboarding_step')->default(0);
            $table->boolean('onboarding_complete')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
