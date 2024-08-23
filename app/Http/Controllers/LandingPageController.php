<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request, default ke bulan dan tahun saat ini
        $month = (int) $request->input('month', Carbon::now()->month);
        $year = (int) $request->input('year', Carbon::now()->year);

        // Tangani perubahan bulan dan tahun
        if ($month < 1) {
            $month = 12;
            $year--;
        } elseif ($month > 12) {
            $month = 1;
            $year++;
        }

         // Default month and year
         $defaultMonth = Carbon::now()->month;
         $defaultYear = Carbon::now()->year;

        // Ambil data peminjaman untuk bulan dan tahun tertentu
        $rents = Peminjaman::with('room', 'user')
            ->whereYear('TanggalPinjam', $year)
            ->whereMonth('TanggalPinjam', $month)
            ->orderBy('TanggalPinjam', 'asc')
            ->orderBy('JamMulai', 'asc')
            ->get();

        // Format tanggal
        foreach ($rents as $item) {
            $item->formattedDate = Carbon::parse($item->TanggalPinjam)
                ->locale('id')
                ->translatedFormat('l, d-m-Y');
        }

        // Pass the rents data and current month/year to the view
        return view('landing-page', [
            'rents' => $rents,
            'currentMonth' => $month,
            'currentYear' => $year,
            'defaultMonth' => $defaultMonth,
            'defaultYear' => $defaultYear,
        ]);
    }
}
