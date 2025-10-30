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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->enum('type', ['video', 'link']);
            $table->string('title');
            $table->longText('description');
            $table->string('thumbnail');
            $table->string('video')->nullable();
            $table->longText('link')->nullable();
            $table->string('states')->nullable();
            $table->string('city')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_promoted')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->enum('visibility', ['Everyone', 'Only me'])->default('Everyone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
