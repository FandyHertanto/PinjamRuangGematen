@extends('layouts.mainlayout')

@section('title', 'Tambah Fasilitas')

@section('content')

<div class="container-fluid">

   

    <div class="card shadow">
        <div class="card-body">
            <div class="mb-3">
                <h3 class="mb-3">Tambah barang</h3>
            </div>
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

            <form action="{{ route('fasilitas-store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="text" name="ruang_id" value="{{ request()->input('ruang_id', old('ruang_id')) }}" hidden>

                <div class="mb-3">
                    <label for="NamaRuang" class="form-label">Nama Ruang</label>
                    <input type="text" name="NamaRuang" value="{{ old('NamaRuang', isset($room) ? $room->NamaRuang : '') }}" id="NamaRuang" class="form-control" placeholder="co: Yohanes" readonly>
                </div>
                <div class="mb-3">
                    <label for="Item" class="form-label">Item</label>
                    <select name="barang_id" id="barang_id" class="form-control">
                        <option value="">Pilih Barang</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->NamaBarang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="JumlahBarang" class="form-label">Jumlah Barang</label>
                    <input type="number" name="JumlahBarang" id="JumlahBarang" class="form-control" placeholder="Masukkan jumlah barang" value="{{ old('JumlahBarang') }}">
                </div>
                <div class="mt-3">
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
