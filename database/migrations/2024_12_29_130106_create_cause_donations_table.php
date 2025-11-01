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
        Schema::create('cause_donations', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->integer('cause_id');
            $table->integer('user_id');
            $table->string('amount');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cause_donations');
    }
};
