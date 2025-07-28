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
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('otp', 6);
            $table->string('key');
            $table->string('key_hash');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_deleted')->default(false);

            $table->timestamps();

            $table->unique('key');
            $table->index('otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_verifications');
    }
};
