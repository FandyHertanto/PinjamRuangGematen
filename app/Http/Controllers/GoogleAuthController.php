<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $google_user = Socialite::driver('google')->user();
        $user = User::where('google_id', $google_user->id)->first();

        if (!$user) {
            // Jika user tidak ada, buat user baru dengan status inactive
            $new_user = User::create([
                'google_id' => $google_user->id,
                'name' => $google_user->name,
                'username' => $google_user->nickname ?? '',
                'email' => $google_user->email,
                'password' => bcrypt('randompassword'), // Generate a random password
                'status' => 'inactive', // Tambahkan status inactive
            ]);

            Session::flash('status', 'berhasil');
            Session::flash('message', 'Daftar Akun Berhasil !! Tunggu Persetujuan Admin');
            return redirect()->route('register');
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
        } else {
            return redirect()->intended('home');
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
