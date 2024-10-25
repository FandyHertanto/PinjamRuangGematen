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
            background-color: #343a40;
            color: #ffffff;
            padding-bottom: 60px;
        }
        .card {
            background-color: #ffffff;
        }
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
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
            padding-bottom: 30px; /* Add space to the bottom of the container */
        }
        .table-responsive {
            margin-top: 1rem;
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
        .page {
            display: none;
        }
        .page.active {
            display: table-row-group;
        }
    </style>
</head>
<body>
    <div class="container mt-3 mb-5">
        <div class="card shadow-lg border-0 rounded-3 rubik-font">
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
                                <th>No.</th>
                                <th>Hari, Tanggal</th>
                                <th>Pukul (WIB)</th>
                                <th>Acara</th>
                                <th>Tempat (Jumlah)</th>
                                <th>Penyelenggara</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        @php
                            $i = 1;
                            $pageCount = 0;
                        @endphp
                        @foreach ($rents as $index => $item)
                            @if ($index % 5 == 0)
                                <tbody class="page {{ $pageCount === 0 ? 'active' : '' }}" id="page-{{ $pageCount }}">
                                @php $pageCount++; @endphp
                            @endif
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->formattedDate }}</td>
                                <td>{{ substr($item->JamMulai, 0, 5) }}-{{ substr($item->JamSelesai, 0, 5) }}</td>
                                <td>{{ $item->Deskripsi }}</td>
                                <td>{{ $item->room->NamaRuang }} ({{ $item->Jumlah }})</td>
                                <td>{{ $item->NamaPeminjam }} ({{ $item->TimPelayanan }})</td>
                                <td>
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
                            @if ($index % 5 == 9 || $index === count($rents) - 1)
                                </tbody>
                            @endif
                        @endforeach
                    </table>
                    <div class="container">
                        <a href="{{ route('ruang/gematen', ['month' => $currentMonth - 1, 'year' => $currentYear]) }}" class="btn btn-nav btn-sm">&lt; Bulan Sebelumnya</a>
                        <a href="{{ route('ruang/gematen', ['month' => $currentMonth + 1, 'year' => $currentYear]) }}" class="btn btn-nav btn-sm">Bulan Berikutnya &gt;</a> <br><br>
                        <a href="{{ route('ruang/gematen', ['month' => $defaultMonth, 'year' => $defaultYear]) }}" class="btn btn-nav btn-sm">Bulan Sekarang</a>
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
            const pages = document.querySelectorAll('.page');
            let currentPage = 0;
            const totalPages = pages.length;

            function showPage(index) {
                pages.forEach((page, i) => {
                    page.classList.toggle('active', i === index);
                });
            }

            function nextPage() {
                currentPage = (currentPage + 1) % totalPages;
                showPage(currentPage);
            }

            setInterval(nextPage, 15000);
            showPage(currentPage);

            const currentMonth = {{ $currentMonth }};
            const currentYear = {{ $currentYear }};
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            document.getElementById('month-year').textContent = `Bulan: ${monthNames[currentMonth - 1]} ${currentYear}`;
        });
    </script>
    <footer class="footer">
        <img src="{{ asset('images/GMA-white.png') }}" alt="Logo Gematen" class="logo mx-3">
        <div>
            <h4 style="margin: 0">Gematen Klaten</h4>
            <p style="margin: 0">Paroki Santa Maria Assumpta Klaten</p>
        </div>
    </footer>
</body>
</html>
