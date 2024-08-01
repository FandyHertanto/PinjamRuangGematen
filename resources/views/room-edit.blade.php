@extends('layouts.mainlayout')
@section('title', 'Edit Ruang')

@section('content')

    <div class="container-fluid">

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                        <h3>Edit Barang</h3>
                    </div>
                    <div class="card-body">
                        

                        <div class="d-flex justify-content-end mb-3">
                            <a class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);" href="{{ route('create-fasilitas', ['ruang_id' => $room->id]) }}"
                                role="button">Tambah Barang</a>
                        </div>

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
                                @php
                                    $reversedFasilitas = $fasilitas->reverse();
                                @endphp
                                @foreach ($reversedFasilitas as $fasil)
                                    <tr>
                                        <td>{{ $fasil->Item->NamaBarang }}</td>
                                        <td>{{ $fasil->Item->Deskripsi }}</td>
                                        <td>{{ $fasil->JumlahBarang }}</td>
                                        <td>
                                            <form action="{{ route('fasilitas-destroy', $fasil->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <input type="text" value="fasil_id" value="{{ $fasil->id }}" hidden>

                                                <a href="{{ route('fasilitas-edit', $fasil->id) }}"
                                                    class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="bi bi-trash3-fill"></i></button>
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

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                        <h3>Edit Ruang</h3>
                    </div>
                    <div class="card-body">
                        
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

                        <form action="{{ route('room-update', $room->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="NamaRuang" class='form-label'>Nama Ruang</label>
                                <input type="text" name="NamaRuang" value='{{ $room->NamaRuang }}' id="NamaRuang"
                                    class="form-control" placeholder="co: Yohanes">
                            </div>
                            <div class="mb-3">
                                <label for="Kapasitas" class='form-label'>Kapasitas</label>
                                <input type="string" name="Kapasitas" value='{{ $room->Kapasitas }}' id="Kapasitas"
                                    class="form-control" placeholder=" Kapasitas ruangan">
                            </div>

                            <div class="mb-3 my-3">
                                <label for="Gambar" class='form-label'>Gambar</label>
                                <input type="file" name="Gambar" id='Gambar' class="form-control">
                                <img src="/Gambar/{{ $room->Gambar }}" alt="" style="max-width: 200px;"
                                    class='mt-3'>
                            </div>

                            <div class="mt-3 text-center">
                                <button class="btn btn-success" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
