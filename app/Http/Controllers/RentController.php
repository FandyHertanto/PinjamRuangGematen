<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Mail;
use App\Models\User; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\FeedbackNotification;
use App\Mail\MailNotify;
use App\Mail\FeedbackMail;


class RentController extends Controller
{

    public function rent()
    {
        // Ambil data peminjaman terbaru dengan pagination
        $rents = Peminjaman::latest()->simplePaginate(25); // Menampilkan 2 peminjaman per halaman
        
        // Kirim data ke view dan menghitung nomor urut
        return view('rent', [
            'rents' => $rents,
            'i' => ($rents->currentPage() - 1) * $rents->perPage() + 1
        ]);
    }
    
    public function cancel(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $now = Carbon::now();
        $tanggalPinjam = Carbon::parse($peminjaman->TanggalPinjam);
        $startDateTime = $tanggalPinjam->setTimeFromTimeString($peminjaman->JamMulai);

        if ($now->greaterThanOrEqualTo($startDateTime)) {
            return redirect()->route('keranjang')->with('error', 'Peminjaman tidak dapat dibatalkan karena sudah berjalan.');
        }

        $peminjaman->Persetujuan = 'dibatalkan';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan oleh pengguna.');
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

public function sendFeedbackEmail(Request $request)
{
    $request->validate([
        'current-item-id' => 'required',
        'message' => 'required',
    ]);

    $users = User::whereIn('role_id', [1, 3])->pluck('email')->toArray();

    foreach ($users as $user) {
        $data = [
            'subject' => 'Layanan Aduan',
            'body' => $request->input('message')
        ];
        Mail::to($user)->send(new FeedbackNotification($data));
    }

    return back()->with('success', 'Pesan telah berhasil dikirim!');
}
}

    

