@extends('layouts.mainlayout')

@section('title', 'Aduan')

@section('content')
    <div class="container my-5 mt-2" style="font-family: 'Rubik';">
        <div class="card shadow">
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th class="col">No.</th>
                            <th class="col">Peminjam</th>
                            <th class="col">Tim Pelayanan</th>
                            <th class="col">Ruang</th>
                            <th class="col">Tanggal Pinjam</th>
                            <th class="col">Jam</th>
                            <th class="col">Keperluan</th>
                            <th class="col">Alat & Barang</th>
                            <th class="col">Lampu & AC</th>
                            <th class="col">Aduan</th>
                        </tr>
                    </thead>
                    <tbody id="rentalTableBody">
                        @php $i = 1; @endphp
                        @foreach ($rents as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->NamaPeminjam }} ({{ $item->TimPelayanan }})</td>

                                
                                <td>{{ $item->room->NamaRuang }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->TanggalPinjam)) }}</td>
                                <td>{{ substr($item->JamMulai, 0, 5) }} - {{ substr($item->JamSelesai, 0, 5) }}</td>
                                <td>{{ $item->Deskripsi }}</td>
                                <td>{{ $item->Aduan1 }}</td>
                                <td>{{ $item->Aduan2 }}</td>
                                <td>{{ $item->Aduan3 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $rents->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
