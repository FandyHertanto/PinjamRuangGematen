<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        
        return view('profile');
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    // Validasi data
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'phone' => 'nullable|regex:/^(\+62)[0-9]{9,13}$/'
    ]);

    try {
        // Update profil pengguna
        $user = auth()->user();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.');
    }
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
