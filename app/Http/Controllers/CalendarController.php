<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function getEvents(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $events = Peminjaman::with(['user', 'room'])
            ->whereDate('TanggalPinjam', '>=', $start)
            ->whereDate('TanggalPinjam', '<=', $end)
            ->get();

        $results = $events->map(function ($event) {
            if ($event->Persetujuan === 'disetujui') {
                $statusText = 'Disetujui';
            } elseif ($event->Persetujuan === 'ditolak') {
                $statusText = 'Ditolak';
            } elseif ($event->Persetujuan === 'dibatalkan') {
                $statusText = 'Dibatalkan';
            } else {
                $statusText = 'Pending';
            }

            return [
                'id' => $event->id,
                'title' => $event->room->NamaRuang,
                'start' => $event->TanggalPinjam . 'T' . $event->JamMulai,
                'end' => $event->TanggalPinjam . 'T' . $event->JamSelesai,
                'description' => $event->Deskripsi,
                'peminjam' => $event->NamaPeminjam,
                'persetujuan' => $statusText
            ];
        });

        return response()->json($results);
    }

    public function create()
    {
        $ruang = Room::all();
        return view('pinjam-add', compact('ruang'));
    }

    public function store(Request $request)
{
    // Define the current date
    $today = \Carbon\Carbon::today()->toDateString();

    // Validate the request
    $request->validate([
        'NamaPeminjam' => 'required',    
        'ruang_id' => 'required',
        'peminjam_id' => 'required',
        'TanggalPinjam' => "required|date|after_or_equal:$today",
        'JamMulai' => 'required',
        'JamSelesai' => 'required',
        'Deskripsi' => 'required',
        'TimPelayanan' => 'required',
        'Jumlah' => 'required|integer|min:1',
    ]);

    $jamMulai = date('H:i', strtotime($request->JamMulai));
    $jamSelesai = date('H:i', strtotime($request->JamSelesai));

    $existingEvent = Peminjaman::where('ruang_id', $request->ruang_id)
        ->where('TanggalPinjam', $request->TanggalPinjam)
        ->where(function ($query) use ($jamMulai, $jamSelesai) {
            $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('JamMulai', '<', $jamSelesai)
                    ->where('JamMulai', '>=', $jamMulai);
            })->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('JamSelesai', '>', $jamMulai)
                    ->where('JamSelesai', '<=', $jamSelesai);
            });
        })
        ->exists();

    if ($existingEvent) {
        return redirect()->route('pinjam.create')->with('error', 'Jadwal tidak tersedia, silahkan pilih jadwal lain')->withInput();
    }

    $peminjaman = new Peminjaman();
    $peminjaman->NamaPeminjam = $request->NamaPeminjam;
    $peminjaman->ruang_id = $request->ruang_id;
    $peminjaman->peminjam_id = $request->peminjam_id;
    $peminjaman->TanggalPinjam = $request->TanggalPinjam;
    $peminjaman->JamMulai = $jamMulai;
    $peminjaman->JamSelesai = $jamSelesai;
    $peminjaman->Deskripsi = $request->Deskripsi;
    $peminjaman->TimPelayanan = $request->TimPelayanan;
    $peminjaman->Jumlah = $request->Jumlah;
    $peminjaman->save();

    $adminEmails = User::where('role_id', 1)->pluck('email')->toArray();

    foreach ($adminEmails as $email) {
        $data = [
            'subject' => 'Notifikasi Peminjaman Ruang',
            'body' => 'Ada peminjaman ruang baru oleh ' . $request->NamaPeminjam .
                ' untuk tanggal ' . $request->TanggalPinjam .
                ' dari jam ' . $request->JamMulai . ' sampai ' . $request->JamSelesai .
                '. Keperluan: ' . $request->Deskripsi
        ];

        Mail::to($email)->send(new MailNotify($data));
    }

    return redirect()->route('pinjam.create')->with('success', 'Peminjaman Ruang Berhasil Ditambahkan');
}

}
