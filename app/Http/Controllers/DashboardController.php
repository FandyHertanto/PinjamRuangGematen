<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah semua pengguna
        $userCount = User::count();

        // Menghitung jumlah semua ruangan
        $roomCount = Room::count();
        $ruangan = Room::orderBy('NamaRuang')->get(['id', 'NamaRuang']);

        // Menghitung jumlah pengguna yang belum di-approve (dengan status 'inactive')
        $unapprovedUserCount = User::where('status', 'inactive')->count();

        // Menghitung jumlah pengguna yang sudah aktif (dengan status 'active')
        $activeUserCount = User::where('status', 'active')->count();

        // Mengambil data peminjaman yang disetujui
        $rents = Peminjaman::where('Persetujuan', 'disetujui')
            ->with('user', 'room') // Ensure relationships are eager loaded
            ->orderBy('TanggalPinjam', 'desc') // Example ordering
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return [
                    'user' => $items->first()->user,
                    'total' => $items->count(),
                    'items' => $items
                ];
            });

        // Mengambil data peminjaman yang disetujui berdasarkan bulan
        $peminjamanData = Peminjaman::where('Persetujuan', 'disetujui')
            ->select(
                DB::raw("COUNT(id) as total_peminjaman"),
                DB::raw('MONTHNAME(TanggalPinjam) as bulan')
            )
            ->groupBy(DB::raw('MONTH(TanggalPinjam)'))
            ->orderBy(DB::raw('MONTH(TanggalPinjam)'))
            ->get();

        $total_peminjaman = $peminjamanData->pluck('total_peminjaman')->toArray();
        $bulan = $peminjamanData->pluck('bulan')->toArray();

        // Mengambil data bulan-bulan yang tersedia dari data peminjaman yang disetujui
        $availableMonths = Peminjaman::where('Persetujuan', 'disetujui')
            ->select(DB::raw('MONTHNAME(TanggalPinjam) as month'))
            ->distinct()
            ->orderBy(DB::raw('MONTH(TanggalPinjam)'))
            ->pluck('month')
            ->toArray();


        // Get available years from approved peminjaman
        $availableYears = Peminjaman::where('Persetujuan', 'disetujui')
            ->select(DB::raw('YEAR(TanggalPinjam) as year'))
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->toArray();

            return view('dashboard', [
                'user_count' => $userCount,
                'room_count' => $roomCount,
                'unapproved_user_count' => $unapprovedUserCount,
                'active_user_count' => $activeUserCount,
                'ruangan' => $ruangan,
                'rents' => $rents,
                'total_peminjaman' => $total_peminjaman,
                'bulan' => $bulan,
                'available_years' => $availableYears,
                'available_months' => $availableMonths, // Menyertakan data bulan yang tersedia
            ]);
            
    }



    public function getChartData($roomId, Request $request)
    {
        try {
            $year = $request->query('year');

            if ($roomId === 'all') {
                // Get data for all rooms and the selected year where Persetujuan = 'disetujui'
                $monthlyData = Peminjaman::where('Persetujuan', 'disetujui')
                    ->whereYear('TanggalPinjam', $year)
                    ->select(
                        'ruang_id',
                        DB::raw('MONTH(TanggalPinjam) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy('ruang_id', 'month')
                    ->orderBy('month', 'asc')
                    ->get();
            } else {
                // Get monthly data for the selected room and year where Persetujuan = 'disetujui'
                $monthlyData = Peminjaman::where('ruang_id', $roomId)
                    ->where('Persetujuan', 'disetujui')
                    ->whereYear('TanggalPinjam', $year)
                    ->select(
                        DB::raw('MONTH(TanggalPinjam) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy('month')
                    ->orderBy('month', 'asc')
                    ->get();
            }

            // Prepare data for chart
            $labels = [];
            $datasets = [];

            // Function to generate random color in hexadecimal format
            function generateRandomColor() {
                return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }

            if ($roomId === 'all') {
                // Group data by room_id for multiple datasets
                foreach ($monthlyData->groupBy('ruang_id') as $roomData) {
                    $roomId = $roomData[0]->ruang_id;
                    $roomName = Room::find($roomId)->NamaRuang; // Get room name
                    $backgroundColor = generateRandomColor(); // Assign random color

                    $values = [];
                    foreach ($roomData as $data) {
                        $monthLabel = date('M', mktime(0, 0, 0, $data->month));
                        $labels[] = $monthLabel;
                        $values[] = $data->count;
                    }

                    $datasets[] = [
                        'label' => $roomName,
                        'data' => $values,
                        'backgroundColor' => $backgroundColor,
                        'borderColor' => $backgroundColor,
                        'borderWidth' => 1,
                    ];
                }
            } else {
                // Single dataset for selected room
                $roomName = Room::find($roomId)->NamaRuang; // Get room name
                $backgroundColor = generateRandomColor(); // Assign random color

                $values = [];
                foreach ($monthlyData as $data) {
                    $monthLabel = date('M', mktime(0, 0, 0, $data->month));
                    $labels[] = $monthLabel;
                    $values[] = $data->count;
                }

                $datasets[] = [
                    'label' => $roomName,
                    'data' => $values,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $backgroundColor,
                    'borderWidth' => 1,
                ];
            }

            return response()->json([
                'labels' => $labels,
                'datasets' => $datasets,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving data'], 500);
        }
    }
    public function getRentData($year, $month)
    {
        $peminjamanData = Peminjaman::where('Persetujuan', 'disetujui')
            ->whereYear('TanggalPinjam', $year)
            ->whereMonth('TanggalPinjam', date('m', strtotime($month)))
            ->with('user', 'room')
            ->get()
            ->groupBy('NamaPeminjam')
            ->map(function ($items) {
                return [
                    'name' => $items->first()->NamaPeminjam,
                    'team' => $items->first()->TimPelayanan,
                    'total_peminjaman' => $items->count(),
                    'details' => $items->map(function ($item) {
                        return [
                            
                            'ruang' => $item->room->NamaRuang,
                            'tanggal_pinjam' => $item->TanggalPinjam,
                            'jam' => substr($item->JamMulai, 0, 5) . ' - ' . substr($item->JamSelesai, 0, 5),
                        ];
                        
                    })
                ];
            })
            ->values();

        return response()->json($peminjamanData);
    }
}


    
