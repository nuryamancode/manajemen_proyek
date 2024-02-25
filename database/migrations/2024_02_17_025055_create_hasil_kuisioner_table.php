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
        Schema::create('hasil_kuisioner', function (Blueprint $table) {
            $table->bigIncrements('id_hasil');
            $table->unsignedBigInteger('tugas_id');
            $table->foreign('tugas_id')->references('id_tugas')->on('tugas')->onDelete('cascade');
            $table->decimal('total_nilai_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_kuisioner');
    }
};
