<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'nik_ketua' => 'required|string|max:20',
            'ktp_ketua' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'telepon_ketua' => 'required|string|max:15',
            'alamat_ketua' => 'required|string',
            'anggota' => 'required|array|max:4',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.nik' => 'required|string|max:20',
        ]);

        // Simpan gambar KTP dan dapatkan path-nya
        $ktpPath = $request->file('ktp_ketua')->store('ktp_images', 'public');

        // Simpan data reservasi ke database
        Reservasi::create([
            'nama_ketua' => $request->nama_ketua,
            'nik_ketua' => $request->nik_ketua,
            'ktp_ketua_path' => $ktpPath,
            'telepon_ketua' => $request->telepon_ketua,
            'alamat_ketua' => $request->alamat_ketua,
            'anggota' => json_encode($request->anggota),
        ]);

        // Redirect atau respon sesuai kebutuhan
        return response()->json(['message' => 'Reservasi berhasil disimpan'], 200);
    }
}
