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
        Schema::create('tugas', function (Blueprint $table) {
            $table->bigIncrements('id_tugas');
            $table->unsignedBigInteger('proyek_id');
            $table->unsignedBigInteger('karyawan_id');
            $table->unsignedBigInteger('direktur_id');
            $table->foreign('direktur_id')->references('id_direktur')->on('direktur')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('proyek_id')->references('id_proyek')->on('proyek')->onDelete('cascade')->onUpdate('cascade');

            $table->string('fase_proyek');
            $table->string('keterangan_tugas');
            $table->string('nama_tugas');
            $table->date('deadline_tugas');
            $table->string('berkas_tugas')->nullable();
            $table->string('upload_berkas')->nullable();
            $table->longText('catatan_karyawan')->nullable();
            $table->longText('catatan_revisi')->nullable();
            $table->enum('status_tugas',['Selesai', 'Revisi', 'Proses', 'Review'])->default('Proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
