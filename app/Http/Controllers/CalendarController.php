<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Room;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Mail\MailNotify;

use Illuminate\Support\Facades\Mail;

class CalendarController extends Controller
{
    public function index()
    {
        // $ruang = Room::all();
        return view('calendar.index');
    }

    public function getEvents(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
    
        $events = Peminjaman::with(['user', 'room'])
            ->whereDate('TanggalPinjam', '>=', $start)
            ->whereDate('TanggalPinjam', '<=', $end)
            ->select('id', 'ruang_id', 'TanggalPinjam', 'JamSelesai', 'JamMulai', 'Deskripsi', 'peminjam_id', 'Persetujuan')
            ->get();
    
        $results = $events->map(function ($event) {
            // Determine status based on Persetujuan field
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
                'peminjam' => $event->user->username,
                'persetujuan' => $statusText
            ];
        });
    
        return response()->json($results);
    }
    
    public function ajax(Request $request)
    {
        switch ($request->type) {
            case "add":
                $peminjaman = Peminjaman::create([
                    'ruang_id' => $request->ruang_id,
                    'JamMulai' => $request->start,
                    'JamSelesai' => $request->end,
                    'Persetujuan' => $request->status
                ]);
                return response()->json($peminjaman);
            case "get":
                $events = Peminjaman::select('id', 'ruang_id as title', 'JamMulai as start', 'JamSelesai as end', 'Persetujuan as status')->get();
                return response()->json($events);
        }
    }

    public function create()
{
    $ruang = Room::all(); // Ambil semua data ruang dari database
    return view('pinjam-add', compact('ruang')); // Tampilkan tampilan form dengan data ruang
}


public function store(Request $request)
{
    $request->validate([
        'ruang_id' => 'required',
        'peminjam_id' => 'required',
        'TanggalPinjam' => 'required|date',
        'JamMulai' => 'required',
        'JamSelesai' => 'required',
        'Deskripsi' => 'required',
        'TimPelayanan' => 'required',
        'Jumlah' => 'required|integer|min:1',
    ]);

    // Format JamMulai dan JamSelesai sesuai dengan format yang diharapkan oleh FullCalendar
    $jamMulai = date('H:i', strtotime($request->JamMulai));
    $jamSelesai = date('H:i', strtotime($request->JamSelesai));

    // Cek ketersediaan ruangan pada waktu yang dipilih
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

    // Jika jadwal sudah terdaftar, kembalikan dengan pesan error
    if ($existingEvent) {
        return redirect()->route('pinjam.create')->with('error', 'Jadwal tidak tersedia, silahkan pilih jadwal lain')->withInput();
    }

    // Jika jadwal belum terdaftar, simpan peminjaman
    $peminjaman = new Peminjaman();
    $peminjaman->ruang_id = $request->ruang_id;
    $peminjaman->peminjam_id = $request->peminjam_id; // Gunakan Auth::user() untuk mengambil user saat ini
    $peminjaman->TanggalPinjam = $request->TanggalPinjam;
    $peminjaman->JamMulai = $jamMulai;
    $peminjaman->JamSelesai = $jamSelesai;
    $peminjaman->Deskripsi = $request->Deskripsi;
    $peminjaman->TimPelayanan = $request->TimPelayanan; // Masukkan TimPelayanan ke dalam model
    $peminjaman->Jumlah = $request->Jumlah; // Masukkan Jumlah ke dalam model
    $peminjaman->save();

    // Ambil semua email admin yang memiliki role_id = 1 (misalnya)
        $adminEmails = User::where('role_id', 1)->pluck('email')->toArray();

        // Send email notification to all admin emails
        foreach ($adminEmails as $email) {
            $data = [
                'subject' => 'Notifikasi Peminjaman Ruang',
                'body' => 'Ada peminjaman ruang baru oleh ' . auth()->user()->username .
                    ' untuk tanggal ' . $request->TanggalPinjam .
                    ' dari jam ' . $request->JamMulai . ' sampai ' . $request->JamSelesai .
                    '. Keperluan: ' . $request->Deskripsi
            ];

            Mail::to($email)->send(new MailNotify($data));
        }

    // Redirect dengan pesan sukses
    return redirect()->route('pinjam.create')->with('success', 'Peminjaman Ruang Berhasil Ditambahkan');
}

}