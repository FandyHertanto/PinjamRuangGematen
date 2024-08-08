@extends('layouts.mainlayout')

@section('title', 'Aduan')

@section('content')
    <div class="container my-5 mt-2" style="font-family: 'Rubik';">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="col">No.</th>
                                <th class="col">Peminjam</th>
                                <th class="col">Ruang</th>
                                <th class="col">Tanggal Pinjam</th>
                                <th class="col">Jam</th>
                                <th class="col">Keperluan</th>
                                <th class="col">Barang</th>
                                <th class="col">Listrik</th>
                                <th class="col">Aduan</th>
                            </tr>
                        </thead>
                        <tbody id="rentalTableBody">
                            @foreach ($rents as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->NamaPeminjam }} ({{ $item->TimPelayanan }})</td>
                                    <td>{{ $item->room->NamaRuang }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->TanggalPinjam)) }}</td>
                                    <td>{{ substr($item->JamMulai, 0, 5) }} - {{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td>{{ $item->Deskripsi }}</td>
                                    <td>
                                        {{ is_null($item->Aduan1) ? '' : ($item->Aduan1 == 1 ? 'Sudah' : 'Belum') }}
                                    </td>
                                    <td>
                                        {{ is_null($item->Aduan2) ? '' : ($item->Aduan2 == 1 ? 'Sudah' : 'Belum') }}
                                    </td>
                                    <td>{{ $item->Aduan3 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $rents->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
