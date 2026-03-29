<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('album_id')->constrained()->cascadeOnDelete();
            $table->index('album_id');
            $table->string('title');
            $table->string('url');
            $table->string('thumbnail_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
