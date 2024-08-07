<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gematen | Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #343a40; /* Dark background color */
            color: #ffffff; /* White text color for contrast */
            padding-bottom: 60px; /* Space for the fixed footer */
        }
        .card {
            background-color: #ffffff; /* White background for card */
            
        }
        .header-container {
            display: flex;
            align-items: center; /* Align items vertically centered */
            justify-content: space-between;
            margin-bottom: 1rem; /* Add margin for spacing */
        }
        .header-content {
            display: flex;
            align-items: center; /* Align items vertically centered */
            gap: 1rem; /* Space between logo and text */
        }
        .logo {
            width: 100px;
            height: 100px;
        }
        .month-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-nav {
            background-color: rgb(163, 1, 1);
            border-color: rgb(163, 1, 1);
            color: #ffffff;
        }
        .btn-nav:hover {
            background-color: rgb(143, 1, 1);
            border-color: rgb(143, 1, 1);
        }
        .container {
            text-align: center;
            
            padding-top: 15px;
            padding-bottom: 30px; Add space to the bottom of the container
        }
        .table-responsive {
            margin-top: 1rem; /* Add space above table */
            margin-bottom: 1rem;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgb(105, 0, 0);
            color: #ffffff;
            display: flex;
            padding: 1rem;
        }
        .footer .logo {
            width: 75px;
            height: 75px;
        }
        .footer div {
            margin-left: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-3 mb-5" >
        <!-- Main Content Card -->
        <div class="card shadow-lg border-0 rounded-3 rubik-font" >
            <div class="card-body">
                <div class="header-container">
                    <div class="header-content">
                        <img src="{{ asset('images/GMA.png') }}" alt="Logo Gematen" class="logo">
                        <div>
                            <h3 style="color:rgb(163, 1, 1);">Agenda Kegiatan Paroki Santa Maria Assumpta Klaten</h3>
                            <div class="month-selector">
                                <h4 id="month-year" style="color:rgb(163, 1, 1);"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="header-buttons">
                        <a href="/login" class="btn btn-primary btn-sm" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">+ Pinjam Ruang</a>
                        
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="col">No.</th>
                                <th class="col">Hari, Tanggal</th>
                                <th class="col">Pukul (WIB)</th>
                                <th class="col">Acara</th>
                                <th class="col">Tempat (Jumlah)</th>
                                <th class="col">Penyelenggara</th>
                                <th class="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="rentalTableBody">
                            @php $i = 1; @endphp
                            @foreach ($rents as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->formattedDate }}</td>
                                    <td>{{ substr($item->JamMulai, 0, 5) }}-{{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td>{{ $item->Deskripsi }}</td>
                                    <td>{{ $item->room->NamaRuang }} ({{ $item->Jumlah }})</td>
                                    <td>{{ $item->NamaPeminjam }} ({{ $item->TimPelayanan }})</td>
                                    <td id="aksi-cell-{{ $item->id }}">
                                        @if ($item->Persetujuan == 'disetujui')
                                            Disetujui
                                        @elseif ($item->Persetujuan == 'ditolak')
                                            Ditolak
                                        @elseif ($item->Persetujuan == 'dibatalkan')
                                            Dibatalkan
                                        @else
                                        Menunggu Persetujuan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="container">
                    <a href="{{ route('ruang/gematen', ['month' => $currentMonth - 1, 'year' => $currentYear]) }}" class="btn btn-nav btn-sm">&lt; Bulan Sebelumnya</a>
                    <a href="{{ route('ruang/gematen', ['month' => $currentMonth + 1, 'year' => $currentYear]) }}" class="btn btn-nav btn-sm">Bulan Berikutnya &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9C38Q1s3Ohv1O1jWjJf5+6bXbtoU32Vf1jblf8F0nA0xSgC2Q4T" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-9o+K7vlZl5n6KZ5u21Kz7d5m39Q6ck8H9r9k1ZW74A5A0V9+bD9xXjZfJ13dxgF8g" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the current month and year from server-side variables
            const currentMonth = {{ $currentMonth }};
            const currentYear = {{ $currentYear }};

            // Define month names
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            // Set the month and year in the HTML
            document.getElementById('month-year').textContent = `Bulan: ${monthNames[currentMonth - 1]} ${currentYear}`;
        });
    </script>
    <footer class="footer" >
        <img src="{{ asset('images/GMA-white.png') }}" alt="Logo Gematen" class="logo mx-3">
        <div>
            Jl. Andalas No.24, Sikenong, <br>
            Kec. Klaten Tengah, Kabupaten Klaten, <br>
            Jawa Tengah 57413 <br>
            (0272) 321866
        </div>
    </footer>
</body>
</html>
