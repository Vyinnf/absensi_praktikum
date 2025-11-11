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
    Schema::create('nilais', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
        $table->integer('modul');
        $table->string('kehadiran')->nullable();
        $table->string('laporan')->nullable();
        $table->string('demo')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
