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
        $events = Peminjaman::with(['user', 'room'])
            
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
            'peminjam_id' => 'required', // Pastikan peminjam_id validasi ada
            'TanggalPinjam' => 'required|date',
            'JamMulai' => 'required|date_format:H:i',
            'JamSelesai' => 'required|date_format:H:i',
        ]);

        // Cek apakah ada jadwal yang sudah terdaftar pada waktu yang sama
        $existingEvent = Peminjaman::where('ruang_id', $request->ruang_id)
            ->where('TanggalPinjam', $request->TanggalPinjam)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('JamMulai', '>=', $request->JamMulai)
                        ->where('JamMulai', '<', $request->JamSelesai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('JamSelesai', '>', $request->JamMulai)
                        ->where('JamSelesai', '<=', $request->JamSelesai);
                });
            })
            ->exists();

        // Jika jadwal sudah terdaftar, kembalikan dengan pesan error
        if ($existingEvent) {
            return redirect()->route('home')->with('error', 'Jadwal tidak tersedia, silahkan pilih jadwal lain')->withInput();
        }

        // Jika jadwal belum terdaftar, simpan peminjaman
        $peminjaman = new Peminjaman();
        $peminjaman->ruang_id = $request->ruang_id;
        $peminjaman->peminjam_id = $request->peminjam_id; // Simpan peminjam_id
        $peminjaman->TanggalPinjam = $request->TanggalPinjam;
        $peminjaman->JamMulai = $request->JamMulai;
        $peminjaman->JamSelesai = $request->JamSelesai;
        $peminjaman->Deskripsi = $request->Deskripsi;
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

        return redirect()->route('home')->with('success', 'Peminjaman Ruang Berhasil Ditambahkan');
    }
}