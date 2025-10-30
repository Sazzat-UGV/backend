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
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('is_suspend')->default(false)->after('visibility');
            $table->string('suspend_reason')->nullable()->after('is_suspend');
            $table->date('suspend_until')->nullable()->after('suspend_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
