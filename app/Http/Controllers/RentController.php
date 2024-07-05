<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class RentController extends Controller
{

    public function rent()
    {
        $rents = Peminjaman::latest()->paginate(5);
        return view('rent', compact('rents'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function cancel($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->Persetujuan = 'dibatalkan';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan');
    }

    public function approve($id)
    {
        // Find the rent by ID
        $rent = Peminjaman::find($id);

        if ($rent) {
            $rent->Persetujuan = 'disetujui';
            $rent->save();

            // Send email notification
            $mailController = new MailController();
            $mailController->sendEmailNotification($id, 'Disetujui');

            // Return a JSON response
            return response()->json(['message' => 'Peminjaman telah disetujui', 'status' => 'disetujui']);
        }

        return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
    }

    public function reject($id)
{
    $rent = Peminjaman::find($id);

    if ($rent) {
        $rent->Persetujuan = 'ditolak';
        $rent->save();

        // Send email notification
        $mailController = new MailController();
        $mailController->sendEmailNotification($id, 'Ditolak');

        return response()->json(['message' => 'Peminjaman telah ditolak', 'status' => 'ditolak']);
    }

    return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
}


    public function approveEmail($id)
    {
        $mailController = new MailController();
        $mailController->sendEmailNotification($id, 'Disetujui');

        return redirect()->back()->with('success', 'Email notifikasi peminjaman yang disetujui telah dikirim');
    }
}