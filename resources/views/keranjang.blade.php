@extends('layouts.mainlayout')

@section('title', 'Keranjang Peminjaman')

@section('content')
    <div class="container">
        <div class="card shadow-lg border-0 rounded-3" style="font-family: 'Rubik';">
            <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                <h3>Histori Peminjaman</h3>
            </div>
            <div class="card-body">
                
                <!-- Search Bar for Global Search -->
                <div class="mb-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari di sini">
                </div>

                <div class="table-responsive">
                    <table class="table text-center" id="rentalTable">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <thead>
                            <tr>
                                <th class="col">No.</th>
                                <th class="col">Tim Pelayanan</th>
                                <th class="col">Ruang</th>
                                <th class="col">Jumlah</th>
                                <th class="col">Tanggal Pinjam</th>
                                <th class="col">Mulai</th>
                                <th class="col">Selesai</th>
                                <th class="col">Keperluan</th>
                                <th class="col">Status</th>
                                <th class="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $now = \Carbon\Carbon::now()->startOfDay(); // Get the start of the current day
                            @endphp
                            @foreach ($peminjamans as $item)
                                
                                @php
                                    $tanggalPinjam = \Carbon\Carbon::parse($item->TanggalPinjam)->startOfDay(); // Get the start of the rental day
                                    $startDateTime = \Carbon\Carbon::parse($item->TanggalPinjam)->setTimeFromTimeString($item->JamMulai);
                                    $endDateTime = \Carbon\Carbon::parse($item->TanggalPinjam)->setTimeFromTimeString($item->JamSelesai);
                                    $oneDayBefore = $startDateTime->copy()->subDay()->startOfDay(); // Start of the day before the rental day
                                @endphp
                                <tr data-date="{{ $tanggalPinjam }}"> <!-- Add data attribute for filtering -->
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->TimPelayanan }}</td>
                                    <td>{{ $item->room->NamaRuang }}</td>
                                    <td>{{ $item->Jumlah }}</td>
                                    <td>{{ $item->TanggalPinjam }}</td>
                                    <td>{{ substr($item->JamMulai, 0, 5) }}</td>
                                    <td>{{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td>{{ $item->Deskripsi }}</td>
                                    <td>
                                        @if ($item->Persetujuan == 'disetujui')
                                            @if ($now->isToday())
                                                Disetujui
                                            @elseif ($now->isPast())
                                                @if (session('aduan_submitted') && session('aduan_submitted') == $item->id)
                                                    Selesai
                                                @else
                                                    Disetujui
                                                @endif
                                            @else
                                                Disetujui
                                            @endif
                                        @elseif ($item->Persetujuan == 'ditolak')
                                            Ditolak
                                        @elseif ($item->Persetujuan == 'pending')
                                            Pending
                                        @elseif ($item->Persetujuan == 'dibatalkan')
                                            Dibatalkan
                                        @else
                                            Selesai
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if ($item->Persetujuan == 'disetujui')
                                            @if ($item->StatusPinjam == 'dibatalkan')
                                                Dibatalkan
                                            @else
                                                @if ($now->isSameDay($oneDayBefore) || $now->isBefore($oneDayBefore))
                                                    <form action="{{ route('rents.cancel', $item->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Batal</button>
                                                    </form>
                                                @endif

                                                @if ($now->isSameDay($tanggalPinjam) || $now->isAfter($tanggalPinjam))
                                                    @if (session('aduan_submitted') && session('aduan_submitted') == $item->id)
                                                        Selesai
                                                    @else
                                                        <form action="{{ route('aduan.get') }}" style="display:inline-block;">
                                                            @csrf
                                                            <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                                            <button type="submit" class="btn btn-primary">Aduan</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $peminjamans->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
        }

        .card-body {
            padding: 1.25rem;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('rentalTable');
            const rows = table.querySelectorAll('tbody tr');
            const tableContainer = document.querySelector('.table-responsive');
            const noDataMessage = document.getElementById('noDataMessage');

            searchInput.addEventListener('input', function() {
                const searchValue = searchInput.value.toLowerCase();
                let hasVisibleRows = false;

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase()
                        .includes(searchValue));

                    if (matches) {
                        row.style.display = '';
                        hasVisibleRows = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (hasVisibleRows) {
                    tableContainer.style.display = '';
                    noDataMessage.style.display = 'none';
                } else {
                    tableContainer.style.display = 'none';
                    noDataMessage.style.display = '';
                }
            });
        });
    </script>
@endsection
