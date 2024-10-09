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
        Schema::create('akreds', function (Blueprint $table) {
            $table->id();
            $table->string('pdf');
            $table->string('prodi');
            $table->string('sk');
            $table->date('awal');
            $table->date('akhir');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akreds');
    }
};
