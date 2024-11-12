<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return Inertia::render('Admin/Index', ['admins' => $admins]);
    }

    public function create()
    {
        return Inertia::render('Admin/Create');
    }

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

    public function edit(Admin $admin)
    {
        return Inertia::render('Admin/Edit', ['admin' => $admin]);
    }

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

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('message', 'Admin deleted successfully.');
    }
}

