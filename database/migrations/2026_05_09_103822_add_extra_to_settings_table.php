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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('tanda_tangan')->nullable();
            $table->integer('digit_nomor')->default(4);
            $table->string('reset_nomor')->default('Tahun'); // Tahun, Bulan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['tanda_tangan', 'digit_nomor', 'reset_nomor']);
        });
    }
};
