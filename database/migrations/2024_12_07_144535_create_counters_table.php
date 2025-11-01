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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('icon1')->default('default_icon1.png');
            $table->string('title1');
            $table->string('number1');
            $table->string('icon2')->default('default_icon2.png');
            $table->string('title2');
            $table->string('number2');
            $table->string('icon3')->default('default_icon3.png');
            $table->string('title3');
            $table->string('number3');
            $table->string('icon4')->default('default_icon4.png');
            $table->string('title4');
            $table->string('number4');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
