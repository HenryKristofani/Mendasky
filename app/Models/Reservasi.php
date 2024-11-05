<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    /**
     * Tentukan tabel yang digunakan oleh model ini (opsional jika tabelnya sudah sesuai konvensi).
     *
     * @var string
     */
    protected $table = 'reservasis';

    /**
     * Tentukan kolom-kolom yang bisa diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nama_ketua',
        'nik_ketua',
        'ktp_ketua_path', // Kolom untuk menyimpan path gambar KTP
        'telepon_ketua',
        'alamat_ketua',
        'anggota', // Kolom JSON untuk menyimpan data anggota kelompok
    ];

    /**
     * Tentukan bahwa kolom `anggota` akan diserialisasi sebagai JSON.
     *
     * @var array
     */
    protected $casts = [
        'anggota' => 'array', // Otomatis decode JSON ke array saat diakses
    ];
}
