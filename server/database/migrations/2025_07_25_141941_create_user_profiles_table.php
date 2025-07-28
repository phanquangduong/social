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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_account_id')
                ->constrained('user_accounts')
                ->onDelete('cascade')
                ->unique();

            $table->string('name');
            $table->string('username')->unique();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->tinyInteger('state')
                ->unsigned()
                ->default(1)
                ->comment('Account status: 0 = Locked, 1 = Active, 2 = Not Activated');

            $table->tinyInteger('gender')
                ->unsigned()
                ->nullable()
                ->comment('Gender: 0 = Secret, 1 = Male, 2 = Female');
            $table->date('birthday')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email')->nullable();

            $table->timestamps();

            $table->unique('email');
            $table->index('mobile');
            $table->index('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
