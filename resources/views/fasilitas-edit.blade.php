@extends('layouts.mainlayout')

@section('title', 'Edit Fasilitas')

@section('content')

    <div class="mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                <h3>Edit Fasilitas</h3>
            </div>
            
            <div class="card-body">
                <form action="{{ route('fasilitas.update', $fasilitas->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="NamaRuang" class='form-label'>Nama Ruang</label>
                            <select name="ruang_id" id="ruang_id" class="form-control">
                                <option value="">Pilih Ruang</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $room->id == $fasilitas->ruang_id ? 'selected' : '' }}>
                                        {{ $room->NamaRuang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="Item" class='form-label'>Item</label>
                            <select name="barang_id" id="barang_id" class="form-control">
                                <option value="">Pilih Barang</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $fasilitas->barang_id ? 'selected' : '' }}>
                                        {{ $item->NamaBarang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="JumlahBarang" class='form-label'>Jumlah Barang</label>
                            <input type="number" name="JumlahBarang" id="JumlahBarang" class="form-control"
                                value="{{ $fasilitas->JumlahBarang }}" placeholder="Masukkan jumlah barang">
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
