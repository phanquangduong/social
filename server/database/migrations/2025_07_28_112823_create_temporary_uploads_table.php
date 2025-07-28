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
        Schema::create('temporary_uploads', function (Blueprint $table) {
            $table->id();
            $table->uuid('upload_session_id');
            $table->foreignId('user_id')->constrained('user_accounts')->onDelete('cascade');
            $table->string('file_path');
            $table->enum('media_type', ['image', 'video']);
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_uploads');
    }
};
