@extends('layouts.mainlayout')

@section('title', 'Keranjang Peminjaman')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center">
                    <h3 class="text-left mb-4">Keranjang Peminjaman</h3>
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
                        @foreach ($peminjamans as $item)
                        <tr>
                            <td>{{ $i++ }}</td>  <!-- Menampilkan nomor urut -->
                            <td>{{ $item->TimPelayanan }}</td>
                            <td>{{ $item->room->NamaRuang }}</td>
                            <td>{{ $item->Jumlah }}</td>
                            <td>{{ $item->TanggalPinjam }}</td>
                            <td>{{ substr($item->JamMulai, 0, 5) }}</td>
                            <td>{{ substr($item->JamSelesai, 0, 5) }}</td>
                            <td>{{ $item->Deskripsi }}</td>
                            <td>
                                @if ($item->Persetujuan == 'disetujui')
                                Disetujui
                                @elseif ($item->Persetujuan == 'ditolak')
                                Ditolak
                                @elseif ($item->Persetujuan == 'dibatalkan')
                                Dibatalkan
                                @else
                                Menunggu
                                @endif
                            </td>
                            <td>
                                <!-- Aksi sesuai dengan status -->
                                @if ($item->Persetujuan == 'menunggu')
                                <a href="{{ route('peminjaman.batal', $item->id) }}" class="btn btn-danger">Batal</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $peminjamans->links('vendor.pagination.custom') }}  <!-- Ganti dengan view pagination Anda jika diperlukan -->
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
@endsection
