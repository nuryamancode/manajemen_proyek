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
        Schema::create('kuisioner', function (Blueprint $table) {
            $table->bigIncrements('id_kuisioner');
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->unsignedBigInteger('subkriteria_id');
            $table->foreign('tugas_id')->references('id_tugas')->on('tugas')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
            $table->foreign('subkriteria_id')->references('id_subkriteria')->on('sub_kriteria')->onDelete('cascade');
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioner');
    }
};
