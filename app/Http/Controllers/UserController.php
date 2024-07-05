<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function keranjang()
    {
        // Ambil ID pengguna yang sedang masuk
        $userId = Auth::id();

        // Ambil data peminjaman yang terkait dengan pengguna saat ini
        $peminjamans = Peminjaman::where('peminjam_id', $userId)->get();

        // Kembalikan view 'keranjang' dengan data peminjaman
        return view('keranjang', ['peminjamans' => $peminjamans]);
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
            // Ubah status pengguna menjadi active
            $user->status = 'active';
            $user->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Pengguna berhasil disetujui dan status diubah menjadi active');
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
    public function promote($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->role_id = 1; // Ubah role menjadi Admin (sesuaikan dengan id role Admin)
        $user->save();

        return redirect()->back()->with('success', 'User role updated to Admin');
    }

    public function demote($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->role_id = 2; // Ubah role menjadi Umat (sesuaikan dengan id role Umat)
        $user->save();

        return redirect()->back()->with('success', 'User role updated to Umat');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('users')->with('success', 'Pengguna berhasil dihapus');
        }
        return redirect()->route('users')->with('error', 'Pengguna tidak ditemukan');
    }
}
