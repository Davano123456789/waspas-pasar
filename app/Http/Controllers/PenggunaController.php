<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = User::with('pasar')->orderBy('peran', 'asc')->get();
        return view('pengguna.index', compact('penggunas'));
    }

    public function create()
    {
        // Manual create only for Admin and Direktur
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pengguna',
            'password' => 'required',
            'nama_lengkap' => 'required',
            'peran' => 'required|in:Admin,Direktur',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'peran' => $request->peran,
            'id_pasar' => null, // Manual entries are not linked to a specific market branch
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $pasars = Pasar::all();
        return view('pengguna.edit', compact('user', 'pasars'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|unique:pengguna,username,' . $id . ',id_pengguna',
            'nama_lengkap' => 'required',
        ]);

        $user->username = $request->username;
        $user->nama_lengkap = $request->nama_lengkap;
        
        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Role can be changed for Admin/Direktur. Kepala Pasar role stays fixed to maintain branch link logic.
        if ($user->peran != 'Kepala Pasar' && $request->filled('peran')) {
            $user->peran = $request->peran;
        }

        $user->save();

        return redirect()->route('pengguna.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id_pengguna == auth()->id()) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('pengguna.index')->with('success', 'Akun berhasil dihapus!');
    }
}
