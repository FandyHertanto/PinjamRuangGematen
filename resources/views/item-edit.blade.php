@extends('layouts.mainlayout')

@section('title', 'Edit Item')

@section('content')

<div class="card shadow-lg border-0 rounded-3" style="font-family: 'Rubik';">
    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
        <h3>Ubah Barang</h3>
    </div>
        <div class="card-body">

            

            <div class="row">
                <div class="col-md-12 ">

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

                    <form action="{{ route('item-update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="NamaBarang" class="form-label">Nama Barang</label>
                            <input type="text" name="NamaBarang" id="NamaBarang" class="form-control"
                                value="{{ $item->NamaBarang }}" placeholder="Masukkan nama barang">
                        </div>
                        <div class="mb-3">
                            <label for="Deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="Deskripsi" id="Deskripsi" >{{ $item->Deskripsi }}</textarea>
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection
