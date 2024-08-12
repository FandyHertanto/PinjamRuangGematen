@extends('layouts.mainlayout')

@section('title', 'Aduan')

@section('content')
    <div class="container my-5 mt-2" style="font-family: 'Rubik';">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center ">
                        <thead>
                            <tr>
                                <th class="col text-center align-middle">No.</th>
                                <th class="col text-center align-middle">Peminjam</th>
                                <th class="col text-center align-middle">Ruang</th>
                                <th class="col text-center align-middle">Tanggal</th>
                                <th class="col text-center align-middle">Jam</th>
                                <th class="col text-center align-middle">Keperluan</th>
                                <th class="col text-center align-middle" style="width: 10%;">Barang dikembalikan</th>
                                <th class="col text-center align-middle" style="width: 10%;">AC & Listrik dimatikan</th>
                                <th class="col text-center align-middle">Aduan</th>
                            </tr>
                        </thead>
                        
                        <tbody id="rentalTableBody">
                            @foreach ($rents as $item)
                                <tr>
                                    <td class="align-middle">{{ $i++ }}</td>
                                    <td class="align-middle text-wrap">{{ $item->NamaPeminjam }} ({{ $item->TimPelayanan }})</td>
                                    <td class="align-middle text-wrap">{{ $item->room->NamaRuang }}</td>
                                    <td class="align-middle">{{ date('d-m-Y', strtotime($item->TanggalPinjam)) }}</td>
                                    <td class="align-middle">{{ substr($item->JamMulai, 0, 5) }} - {{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td class="align-middle text-wrap">{{ $item->Deskripsi }}</td>
                                    <td class="align-middle">
                                        {!! is_null($item->Aduan1) ? '' : ($item->Aduan1 == 1 ? '<i class="bi bi-check-circle text-success fs-4"></i>' : '<i class="bi bi-x-circle text-danger fs-4"></i>') !!}
                                    </td>
                                    <td class="align-middle">
                                        {!! is_null($item->Aduan2) ? '' : ($item->Aduan2 == 1 ? '<i class="bi bi-check-circle text-success fs-4"></i>' : '<i class="bi bi-x-circle text-danger fs-4"></i>') !!}
                                    </td>
                                    <td class="align-middle text-wrap">{{ $item->Aduan3 }}</td>
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
