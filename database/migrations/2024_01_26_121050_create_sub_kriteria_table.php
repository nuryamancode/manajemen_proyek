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
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->bigIncrements('id_subkriteria');
            $table->string('nama_subkriteria');
            $table->unsignedBigInteger('kriteria_id');
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};
