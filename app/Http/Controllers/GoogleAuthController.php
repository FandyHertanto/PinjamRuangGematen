<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\NewUserNotification;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            // Handle exception when user cancels the authentication
            return redirect()->route('login')->withErrors(['login diabtalkan']);
        }
        $user = User::where('google_id', $google_user->id)->first();

        if (!$user) {
            // Jika user tidak ada, buat user baru dengan status inactive
            $new_user = User::create([
                'google_id' => $google_user->id,
                'name' => $google_user->name,
                'username' => $google_user->name ?? explode('@', $google_user->email)[0], // Menggunakan bagian depan dari email sebagai username jika nickname tidak ada
                'email' => $google_user->email,
                // 'password' => bcrypt(''), // Generate a random password
                'phone' => $google_user->phone ?? null,
                'status' => 'inactive', // Tambahkan status inactive
            ]);

            // Kirim email notifikasi ke admin
            $adminEmails = User::whereIn('role_id', [1, 3])->pluck('email')->toArray();
            foreach ($adminEmails as $email) {
                $data = [
                    'subject' => 'Aktivasi Pengguna',
                    'body' => 'Pengguna baru telah mendaftar dengan email: ' . $new_user->email . '. Silahkan cek dan aktifkan akun tersebut.'
                ];

                Mail::to($email)->send(new NewUserNotification($data));
            }

            Session::flash('status', 'berhasil');
            
            return redirect()->route('register')->withErrors(['Daftar Akun Berhasil !! Tunggu Persetujuan Admin']);
        }

        // Jika user sudah ada, periksa statusnya
        if ($user->status === 'inactive') {
            Auth::logout();
            Session::flush(); // Membersihkan session
            return redirect()->route('login')->withErrors(['Akun Anda Belum Aktif, Silahkan Hubungi Admin!']);
        }

        // Jika user aktif, login dan arahkan sesuai role id
        Auth::login($user);
        if ($user->role_id == 1) {
            return redirect()->route('dashboard');
        } elseif ($user->role_id == 2) {
            return redirect()->route('home');
        } elseif ($user->role_id == 3) {
                return redirect()->route('dashboard');
        } else {
            return redirect()->intended('pinjam-ruang');
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Berhasil login, periksa status user
            $user = Auth::user();

            if ($user->status === 'inactive') {
                Auth::logout();
                Session::flush(); // Membersihkan session
                return redirect()->route('login')->withErrors(['Akun Anda Belum Aktif, Silahkan Hubungi Admin!']);
            }

            // User aktif, arahkan sesuai role id
            if ($user->role_id == 1) {
                return redirect()->route('dashboard');
            } elseif ($user->role_id == 2) {
                return redirect()->route('home');
            } else {
                return redirect()->intended('home');
            }
        }

        // Gagal login, kembalikan dengan pesan error
        return redirect()->route('login')->withErrors(['login invalid, silahkan daftar akun']);
    }
}
