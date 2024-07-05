@extends('layouts.mainlayout')

@section('title', 'Keranjang')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h3 class="card-title">Peminjaman {{ Auth::user()->username }} </h3>

        <div class="my-5">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Ruang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $peminjamans = $peminjamans->reverse(); // Memutar urutan koleksi
                    @endphp
                    @foreach ($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $peminjaman->room->NamaRuang }}</td>
                        <td>{{ $peminjaman->TanggalPinjam }}</td>
                        <td>{{ $peminjaman->JamMulai }}</td>
                        <td>{{ $peminjaman->JamSelesai }}</td>
                        <td>{{ $peminjaman->Deskripsi }}</td>
                        <td>{{ $peminjaman->Persetujuan }}</td>
                        <td>
                            @if ($peminjaman->Persetujuan == 'disetujui')
                                @if ($peminjaman->StatusPinjam != 'dibatalkan')
                                    <form action="{{ route('rents.cancel', $peminjaman->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Batal</button>
                                    </form>
                                @else
                                    <span>Dibatalkan</span>
                                @endif
                            @elseif ($peminjaman->Persetujuan == 'ditolak')
                                Ditolak
                            @elseif ($peminjaman->Persetujuan == 'pending')
                                pending
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection
