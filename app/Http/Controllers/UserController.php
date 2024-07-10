<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserApprovedNotification;
use App\Mail\UserRejectedNotification;

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
        // Ambil semua pengguna dengan role ID 1, 2 (Admin, Umat) yang statusnya 'active'
        $users = User::whereIn('role_id', [User::ROLE_ADMIN, User::ROLE_UMAT])
            ->where('status', 'active')
            ->get();

        return view('user', ['users' => $users]);
    }


    public function registeredUser()
    {
        $registeredUsers = User::where('status', 'inactive')->get();
        return view('registered-user', ['registeredUsers' => $registeredUsers]);
    }

    public function approve($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = 'active';
            $user->save();

            // Kirim notifikasi email
            Mail::to($user->email)->send(new UserApprovedNotification($user));

            return redirect()->back()->with('success', 'Pengguna berhasil disetujui dan status diubah menjadi active');
        } else {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }
    }

    public function reject($id)
{
    $user = User::find($id);

    if ($user) {
        // Tandai pengguna sebagai ditolak
        $user->rejection_status = 'rejected';
        $user->save();

        // Kirim notifikasi email
        Mail::to($user->email)->send(new UserRejectedNotification($user));

        return redirect()->back()->with('success', 'Pengguna telah ditolak');
    } else {
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

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }

        // Ambil data peminjaman yang terkait dengan pengguna saat ini
        $peminjamans = Peminjaman::where('peminjam_id', $id)->get();

        // Kembalikan view 'user-detail' dengan data pengguna dan peminjaman
        return view('user-detail', ['user' => $user, 'peminjamans' => $peminjamans]);
    }
}
