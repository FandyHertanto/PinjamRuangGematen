<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile');
    }
    public function index()
    {
        $users = User::all()->where('status', 'active');
        return view('user', ['users' => $users]);
    }
    public function registeredUser()
    {
        $registeredUsers = User::where('status', 'inactive')->get();
        return view('registered-user', ['registeredUsers' => $registeredUsers]);
    }

    public function approve($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan
        if ($user) {
            // Ubah status pengguna menjadi aktif
            $user->status = 'active';
            $user->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Pengguna berhasil diaktifkan');
        } else {
            // Redirect kembali dengan pesan error jika pengguna tidak ditemukan
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }
    }
    public function reject($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan
        if ($user) {
            // Lakukan aksi penolakan, misalnya menghapus pengguna atau mengubah status
            $user->delete();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Pengguna berhasil ditolak');
        } else {
            // Redirect kembali dengan pesan error jika pengguna tidak ditemukan
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }
    }
}
