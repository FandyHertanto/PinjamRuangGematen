<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserNotification;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function authenticating(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Memeriksa apakah input adalah email
        $input = $request->input('email');
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // Jika input adalah email, otentikasi dengan email
            $credentials['email'] = $input;
            unset($credentials['username']); // Hapus 'username' jika ada
        } else {
            // Jika input bukan email, anggapnya sebagai username
            $credentials['username'] = $input;
            unset($credentials['email']); // Hapus 'email' jika ada
        }

        if (Auth::attempt($credentials)) {
            // Cek apakah status = active
            if (Auth::user()->status != 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('login')
                    ->withErrors(['Akun Anda Belum Aktif, Silahkan Hubungi Admin!']); // Menampilkan pesan kesalahan
            }

            $request->session()->regenerate(); //biar ngga ditendang di halaman tertentu

            if (Auth::user()->role_id == 1) {
                return redirect('dashboard');
            }
            
            //ini role umat , role romo nanti
            if (Auth::user()->role_id == 2) {
                return redirect('home');
            }
            if (Auth::user()->role_id == 3) {
                return redirect('dashboard');
            }
        }

        return redirect('/login')
            ->withErrors(['Login invalid']); // Menampilkan pesan kesalahan
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function registerProses(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|max:255',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 'inactive',
        ]);

        // Kirim email notifikasi ke admin
        $adminEmails = User::where('role_id', 1)->pluck('email')->toArray();
        foreach ($adminEmails as $email) {
            $data = [
                'subject' => 'Pengguna Baru Terdaftar',
                'body' => 'Pengguna baru telah mendaftar dengan email: ' . $user->email . '. Silahkan cek dan aktifkan akun tersebut.'
            ];

            Mail::to($email)->send(new NewUserNotification($data));
        }

        Session::flash('status', 'berhasil');
        Session::flash('message', 'Daftar Akun Berhasil !! Tunggu Persetujuan Admin');
        return redirect('register');
    }
}
