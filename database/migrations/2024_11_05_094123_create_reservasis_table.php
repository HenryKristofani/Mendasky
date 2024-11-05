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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ketua');
            $table->string('nik_ketua');
            $table->string('ktp_ketua_path'); // Menyimpan path gambar KTP
            $table->string('telepon_ketua');
            $table->text('alamat_ketua');
            $table->json('anggota'); // Menyimpan data anggota dalam bentuk JSON
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
