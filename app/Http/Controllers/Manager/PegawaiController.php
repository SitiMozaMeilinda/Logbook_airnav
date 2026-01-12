<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PegawaiController extends Controller
{
    /**
     * Menampilkan form tambah data pegawai
     */
    public function create()
    {
        $teknisi = User::where('role', 'teknisi')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('manager.tambahdatapegawai', compact('teknisi'));
    }

    /**
     * Menyimpan data pegawai ke tabel users
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name, // atau bisa diganti sesuai kebutuhan
            'username' => $request->username,
            'password' => Hash::make($request->password), // crypt/hash
            'role'     => 'teknisi',
        ]);

        return redirect()
            ->route('manager.tambahdatapegawai')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'teknisi') {
            // Hapus semua aktivitas terkait terlebih dahulu agar tidak error constraint
            $user->activities()->delete(); 
            
            // Baru hapus usernya
            $user->delete();

            return redirect()->back()->with('success', 'Teknisi dan seluruh aktivitasnya berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus data');
    }
}
