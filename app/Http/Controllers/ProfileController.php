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
    $user = Auth::user(); // Mengambil user yang sedang login
    
    // Validasi data input jika diperlukan
    $validatedData = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
    ]);
    
    // Update data user
    $user->username = $validatedData['username'];
    $user->email = $validatedData['email'];
    $user->phone = $validatedData['phone'];
    $user->save();
    
    return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui.');
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
