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
        Schema::create('proyek', function (Blueprint $table) {
            $table->bigIncrements('id_proyek');
            $table->string('nama_proyek');
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_selesai');
            $table->enum('status_proyek',['Done', 'In Progress'])->default('In Progress');
            $table->enum('level_proyek',['Sulit', 'Mudah', 'Sedang']);
            $table->unsignedBigInteger('klien_id');
            $table->foreign('klien_id')->references('id_klien')->on('klien')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek');
    }
};
