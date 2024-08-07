<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Models\Peminjaman;
use App\Mail\FeedbackNotification;


class MailController extends Controller
{
    public function sendEmailNotification($rentId, $status)
{
    $rent = Peminjaman::find($rentId);
    if (!$rent) {
        return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
    }

    $username = $rent->user->username;
    $ruang = $rent->room->NamaRuang;
    $userEmail = $rent->user->email;

    $subject = 'Peminjaman Ruang';
    $body = "Halo $username,\n";

    // if ($status == 'disetujui') {
    //     $body .= "Peminjaman ruang untuk ruangan $ruang telah disetujui.\n";
    // } elseif ($status == 'ditolak') {
    //     $body .= "Peminjaman ruang untuk ruangan $ruang telah ditolak.\n";
    // } elseif ($status == 'dibatalkan') {
    //     $body .= "Peminjaman ruang untuk ruangan $ruang telah dibatalkan.\n";
    // } else {
    //     return redirect()->back()->with('error', 'Status peminjaman tidak valid');
    // }

    $data = [
        'subject' => $subject,
        'body' => $body
    ];

    try {
        Mail::to($userEmail)->send(new MailNotify($data));
        return redirect()->back()->with('success', 'Email notifikasi berhasil dikirim');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal mengirim email notifikasi: ' . $e->getMessage());
    }
}


public function sendEmail(Request $request)
{
    $recipient = $request->input('recipient');
    $message = $request->input('message');

    $data = [
        'subject' => 'Peminjaman Ruang',
        'body' => $message
    ];

    try {
        Mail::to($recipient)->send(new FeedbackNotification($data));
        return response()->json(['message' => 'Email notifikasi berhasil dikirim'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Gagal mengirim email notifikasi: ' . $e->getMessage()], 500);
    }
}




}
