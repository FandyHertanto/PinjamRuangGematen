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

    if ($status == 'disetujui') {
        $body .= "Peminjaman ruang untuk ruangan $ruang telah disetujui.\n";
    } elseif ($status == 'ditolak') {
        $body .= "Peminjaman ruang untuk ruangan $ruang telah ditolak.\n";
    } elseif ($status == 'dibatalkan') {
        $body .= "Peminjaman ruang untuk ruangan $ruang telah dibatalkan.\n";
    } else {
        return redirect()->back()->with('error', '');
    }

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
        $data = [
            'subject' => 'Pemberitahuan Peminjaman',
            'body' => $request->message
        ];

        Mail::raw($data['body'], function($message) use ($data, $request) {
            $message->to($request->recipient)
                    ->subject($data['subject'])
                    ->from('gematendeveloper@gmail.com', 'Peminjaman Ruang Gematen');
        });

        return response()->json(['status' => 'success']);
    }
}





