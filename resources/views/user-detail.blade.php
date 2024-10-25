@extends('layouts.mainlayout')

@section('title', 'Detail Pengguna')

@section('content')

    <div class="card border-0" style="font-family: 'Rubik';">
        <div class="card-body">
            <h3 class="card-title text-left">Detail Pengguna, {{ $user->username }}</h3>

            <div class="my-3">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            {{-- <li class="list-group-item">Nama: {{ $user->username }}</li> --}}
                            <li class="list-group-item">No HP: {{ $user->phone }}</li>
                            {{-- <li class="list-group-item">Email: {{ $user->email }}</li> --}}
                            <li class="list-group-item">Status: {{ $user->status }}</li>
                            <li class="list-group-item">
                                Role:
                                @if ($user->role_id == 1)
                                    Admin
                                @elseif ($user->role_id == 2)
                                    Umat
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 d-flex align-items-center justify-content-start">
                        <div>
                            @if ($user->role_id == 1)
                                <form action="{{ route('users.demote', ['id' => $user->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm">Ubah ke Umat</button>
                                </form>
                            @elseif ($user->role_id == 2)
                                <form action="{{ route('users.promote', ['id' => $user->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-info btn-sm">Ubah ke Admin</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                    <h3>Riwayat Peminjaman</h3>
                </div>
                @if ($peminjamans->count() > 0)
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> <!-- Penomoran otomatis dengan $loop -->
                                        <td>{{ $peminjaman->room->NamaRuang }}</td>
                                        <td>{{ date('d-m-Y', strtotime($peminjaman->TanggalPinjam)) }}</td>
                                        <td>{{ date('H:i', strtotime($peminjaman->JamMulai)) }}</td>
                                        <td>{{ date('H:i', strtotime($peminjaman->JamSelesai)) }}</td>
                                        <td>{{ $peminjaman->Deskripsi }}</td>
                                        <td>{{ $peminjaman->Persetujuan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>Belum ada riwayat peminjaman untuk pengguna ini.</p>
                @endif
            </div> 
        </div>
    </div>

@endsection
