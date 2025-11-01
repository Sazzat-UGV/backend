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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('short_description');
            $table->text('description');
            $table->string('featured_photo')->default('default-event.png');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('date');
            $table->string('time');
            $table->string('location');
            $table->text('map')->nullable();
            $table->integer('price')->default(0);
            $table->integer('total_seat')->default(0);
            $table->integer('booked_seat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
