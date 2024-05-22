@extends('layouts.mainlayout')
@section('title', 'Edit Ruang')

@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Edit Ruang</h3>
            </div>
        </div>
    </div>

    <div class="mt-5 w-50">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('room-update', $room->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="NamaRuang" class='form-label'>Nama Ruang</label>
                <input type="text" name="NamaRuang" value='{{ $room->NamaRuang }}' id="NamaRuang" class="form-control"
                    placeholder="co: Yohanes">
            </div>
            <div class="mb-3">
                <label for="Kapasitas" class='form-label'>Kapasitas</label>
                <input type="number" name="Kapasitas" id="Kapasitas" class="form-control" placeholder=" Kapasitas ruangan">
            </div>

            <div class="mb-3">
                <label for="Gambar" class='form-label,'>Gambar</label>
                <input type="file" name="Gambar" id='Gambar' class="form-control">
                <img src="/Gambar/{{ $room->Gambar }}" alt="" style="max-width: 200px;">
            </div>

            <div class="mt-3">
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex">
                    <h2 class="p-2">Barang</h2>
                    <div class="ms-auto p-2">
                        <a class="btn btn-primary" href="{{ route('create-fasilitas', ['ruang_id' => $room->id]) }}" role="button">Tambah Barang</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fasilitas as $fasil)
                                    <tr>
                                        <td>{{ $fasil->Item->NamaBarang }}</td>
                                        <td>{{ $fasil->Item->Deskripsi }}</td>
                                        <td>{{ $fasil->JumlahBarang }}</td>
                                        <td>
                                            <form action="{{ route('fasilitas-destroy', $fasil->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <input type="text" value="fasil_id" value="{{ $fasil->id }}" hidden>

                                                <a href="{{ route('fasilitas-edit', $fasil->id) }}" class="btn btn-warning">Edit</a>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
