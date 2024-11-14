<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Display a list of all admins (optional)
    public function index()
    {
        $admins = Admin::all();
        return Inertia::render('Admin/Index', ['admins' => $admins]);
    }

    // Show the form for creating a new admin (optional)
    public function create()
    {
        return Inertia::render('Admin/Create');
    }

    // Store a new admin in the database (optional)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admins.index')->with('message', 'Admin created successfully.');
    }

    // Show the form for editing the specified admin (optional)
    public function edit(Admin $admin)
    {
        return Inertia::render('Admin/Edit', ['admin' => $admin]);
    }

    // Update the specified admin in the database (optional)
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admins.index')->with('message', 'Admin updated successfully.');
    }

    // Delete the specified admin (optional)
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('message', 'Admin deleted successfully.');
    }

    // Display all reservations made by users
    public function showReservations()
    {
        $reservasis = Reservasi::with('user')->get(); // Retrieve all reservations with user data
        return Inertia::render('DashboardView', ['reservasis' => $reservasis]);
    }

    // Delete a specific reservation (Action for admin)
    public function deleteReservation($id)
    {
        $reservation = Reservasi::findOrFail($id);
        $reservation->delete();
        return redirect()->route('admin.dashboard')->with('message', 'Reservation deleted successfully.');
    }

    // Show the form for editing a specific reservation (Action for admin)
    public function editReservation($id)
    {
        $reservation = Reservasi::findOrFail($id);
        return Inertia::render('EditReservasiView', ['reservation' => $reservation]);
    }
    

    // Update a specific reservation (Action for admin)
    public function updateReservation(Request $request, $id)
    {
        $reservation = Reservasi::findOrFail($id);
    
        // Validate only the fields that can be updated
        $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'nik_ketua' => 'required|string|max:20'
        ]);
    
        // Update only the specified fields
        $reservation->update([
            'nama_ketua' => $request->nama_ketua,
            'nik_ketua' => $request->nik_ketua
        ]);
    
        return redirect()->route('admin.dashboard')->with('message', 'Reservation updated successfully.');
    }
    
    

    // Show the details of a specific reservation (Action for admin)
    public function showReservationDetail($id)
    {
        $reservasi = Reservasi::with('user')->findOrFail($id); // Fetch reservation and related user data if needed
        return Inertia::render('Dashboard/DetailKelompokView', [
            'reservasi' => $reservasi
        ]);
    }



    // Fungsi untuk mendapatkan jumlah pendaki pada hari ini
    public function getPendakiHariIni()
    {
    // Menghitung jumlah pendaki pada hari ini
        $jumlahPendakiHariIni = Reservasi::whereDate('tanggal_reservasi', today())->count();
        return Inertia::render('KuotaView', [
                'jumlahPendakiHariIni' => $jumlahPendakiHariIni
        ]);
    }


    public function getKuotaByDate($date)
    {
        // Ambil seluruh data reservasi yang sesuai dengan tanggal yang dipilih
        $reservasis = Reservasi::whereDate('tanggal_reservasi', $date)->get();

        // Mengambil jumlah seluruh pendaki (termasuk ketua dan anggota)
        $kuota = 0;
        foreach ($reservasis as $reservasi) {
            // Jumlahkan ketua dan anggota
            $kuota += 1; // Ketua Kelompok
            $anggota = json_decode($reservasi->anggota, true);
            $kuota += count($anggota); // Anggota Kelompok
        }

        return response()->json(['kuota' => $kuota]);
    }


    
    
}
