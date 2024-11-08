<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ReservasiController extends Controller
{
    // Retrieve all reservations
    public function index()
    {
        $reservasis = Reservasi::all();
        return response()->json($reservasis, 200);
    }

    // Show details of a specific reservation
    public function show($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        return response()->json($reservasi, 200);
    }

    // Store a new reservation
    public function store(Request $request)
    {
        // Validate input data
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

        // Save KTP image and get path
        $ktpPath = $request->file('ktp_ketua')->store('ktp_images', 'public');

        // Create reservation record in the database
        Reservasi::create([
            'nama_ketua' => $request->nama_ketua,
            'nik_ketua' => $request->nik_ketua,
            'ktp_ketua_path' => $ktpPath,
            'telepon_ketua' => $request->telepon_ketua,
            'alamat_ketua' => $request->alamat_ketua,
            'anggota' => json_encode($request->anggota),
        ]);

        return response()->json(['message' => 'Reservasi berhasil disimpan'], 200);
    }

    // Update a reservation
    public function update(Request $request, $id)
    {
        // Find the reservation by ID
        $reservasi = Reservasi::findOrFail($id);

        // Validate input data
        $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'nik_ketua' => 'required|string|max:20',
            'telepon_ketua' => 'required|string|max:15',
            'alamat_ketua' => 'required|string',
            'anggota' => 'required|array|max:4',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.nik' => 'required|string|max:20',
        ]);

        // Update the KTP image if provided
        if ($request->hasFile('ktp_ketua')) {
            // Delete the old KTP image
            Storage::disk('public')->delete($reservasi->ktp_ketua_path);

            // Store the new KTP image and update path
            $ktpPath = $request->file('ktp_ketua')->store('ktp_images', 'public');
            $reservasi->ktp_ketua_path = $ktpPath;
        }

        // Update other reservation details
        $reservasi->update([
            'nama_ketua' => $request->nama_ketua,
            'nik_ketua' => $request->nik_ketua,
            'telepon_ketua' => $request->telepon_ketua,
            'alamat_ketua' => $request->alamat_ketua,
            'anggota' => json_encode($request->anggota),
        ]);

        return response()->json(['message' => 'Reservasi berhasil diupdate'], 200);
    }

    // Delete a reservation
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Delete the KTP image from storage
        Storage::disk('public')->delete($reservasi->ktp_ketua_path);

        // Delete the reservation record
        $reservasi->delete();

        return response()->json(['message' => 'Reservasi berhasil dihapus'], 200);
    }

    // Method to edit a reservation
    public function edit($id)
    {
        // Retrieve the reservation data by ID
        $reservasi = Reservasi::findOrFail($id);

        // Send the data to the edit view via Inertia
        return Inertia::render('EditReservasiView', [
            'reservasi' => [
                'id' => $reservasi->id,
                'nama_ketua' => $reservasi->nama_ketua,
                'nik_ketua' => $reservasi->nik_ketua,
                'telepon_ketua' => $reservasi->telepon_ketua,
                'alamat_ketua' => $reservasi->alamat_ketua,
                'ktp_ketua_path' => $reservasi->ktp_ketua_path,
                'anggota' => json_decode($reservasi->anggota, true),
            ],
        ]);
    }
}