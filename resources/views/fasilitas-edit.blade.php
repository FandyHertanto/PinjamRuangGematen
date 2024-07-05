    <!-- @extends('layouts.mainlayout')

@section('title', 'Edit Fasilitas')

@section('content')

    <h3>Edit Fasilitas</h3>

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

        <form action="{{ route('fasilitas.update', $fasilitas->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="NamaRuang" class='form-label'>Nama Ruang</label>
                <select name="ruang_id" id="ruang_id" class="form-control">
                    <option value="">Pilih Ruang</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $room->id == $fasilitas->ruang_id ? 'selected' : '' }}>
                            {{ $room->NamaRuang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="Item" class='form-label'>Item</label>
                <select name="barang_id" id="barang_id" class="form-control">
                    <option value="">Pilih Barang</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $fasilitas->barang_id ? 'selected' : '' }}>
                            {{ $item->NamaBarang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="JumlahBarang" class='form-label'>Jumlah Barang</label>
                <input type="number" name="JumlahBarang" id="JumlahBarang" class="form-control"
                    value="{{ $fasilitas->JumlahBarang }}" placeholder="Masukkan jumlah barang">
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </form>
    </div>

@endsection -->
