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
    public function aduan(Request $request)
    {
        $peminjamanId = $request->input('peminjaman_id');
        $peminjaman = Peminjaman::with('room')->find($peminjamanId);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Peminjaman not found.');
        }

        return view('aduan', ['peminjaman' => $peminjaman]);
    }

    public function postAduan(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'Aduan1' => 'required|boolean',
            'Aduan2' => 'required|boolean',
            'Aduan3' => 'required|string',
        ]);

        // Find the Peminjaman record
        $peminjaman = Peminjaman::findOrFail($validatedData['peminjaman_id']);
        $peminjaman->update(['Persetujuan' => 'selesai']);

        // Update the aduan fields
        $peminjaman->Aduan1 = $validatedData['Aduan1'];
        $peminjaman->Aduan2 = $validatedData['Aduan2'];
        $peminjaman->Aduan3 = $validatedData['Aduan3'];
        $peminjaman->save();

        // Redirect with success message to 'keranjang' route
        return redirect()->route('keranjang')->with('success', 'Aduan berhasil dikirim.');
    }
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'NamaPeminjam' => 'required|string|max:255',
            'TimPelayanan' => 'required|string|max:255',
            'Jumlah' => 'required|integer|min:1',
            'ruang_id' => 'required|exists:ruang,id',
            'TanggalPinjam' => 'required|date|after_or_equal:today',
            'JamMulai' => 'required|date_format:H:i',
            'JamSelesai' => 'required|date_format:H:i|after:JamMulai',
            'Deskripsi' => 'required|string|max:255',
            'peminjam_id' => 'required|exists:users,id'
        ]);

        $tanggalPinjam = Carbon::parse($validatedData['TanggalPinjam']);
        $jamMulai = Carbon::parse($validatedData['JamMulai']);
        $jamSelesai = Carbon::parse($validatedData['JamSelesai']);

        // Cek jika ada peminjaman yang berbenturan
        $conflictingRentals = Peminjaman::where('ruang_id', $validatedData['ruang_id'])
            ->whereDate('TanggalPinjam', $tanggalPinjam)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('JamMulai', [$jamMulai, $jamSelesai])
                      ->orWhereBetween('JamSelesai', [$jamMulai, $jamSelesai])
                      ->orWhere(function ($query) use ($jamMulai, $jamSelesai) {
                          $query->where('JamMulai', '<=', $jamMulai)
                                ->where('JamSelesai', '>=', $jamSelesai);
                      });
            })
            ->whereIn('Persetujuan', ['pending', 'disetujui'])
            ->exists();

        if ($conflictingRentals) {
            return redirect()->back()->with('error', 'Ruangan sudah terdaftar untuk waktu yang dipilih.');
        }

        // Simpan peminjaman baru
        Peminjaman::create($validatedData);

        return redirect()->route('keranjang')->with('success', 'Peminjaman berhasil dibuat.');
    }
}

