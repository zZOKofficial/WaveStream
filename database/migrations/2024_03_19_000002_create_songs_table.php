<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->string('album')->nullable();
            $table->string('file_path');
            $table->string('cover_image')->nullable();
            $table->integer('duration')->nullable(); // duration in seconds
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete(); // clearer than onDelete('set null')
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
