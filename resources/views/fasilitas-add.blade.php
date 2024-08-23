@extends('layouts.mainlayout')

@section('title', 'Tambah Fasilitas')

@section('content')

    <div class="container-fluid">



        <div class="card shadow" style="font-family: 'Rubik';">
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="mb-3">Tambah barang</h3>
                </div>
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
                <form action="{{ route('fasilitas-store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="text" name="ruang_id" value="{{ request()->input('ruang_id', old('ruang_id')) }}"
                        hidden>

                        <div class="mb-3">
                            <label for="NamaRuang" class="form-label">Nama Ruang</label>
                            <div id="NamaRuang" class="form-control" style="background-color: #e9ecef; cursor: not-allowed;">
                                {{ old('NamaRuang', isset($room) ? $room->NamaRuang : 'N/A') }}
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="Item" class="form-label">Pilih Barang</label>
                                <select name="barang_id" id="barang_id" class="form-control" onchange="updateDescription()" required>
                                    <option value="" >Pilih Barang</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}" data-deskripsi="{{ $item->Deskripsi }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->NamaBarang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Deskripsi" class="form-label">Deskripsi</label>
                                <div id="Deskripsi" class="form-control" style="background-color: #e9ecef; cursor: not-allowed;">
                                    @php
                                        $selectedItem = $items->firstWhere('id', old('barang_id', ''));
                                    @endphp
                                    {{ $selectedItem ? $selectedItem->Deskripsi : 'Deskripsi akan ditampilkan di sini' }}
                                </div>
                            </div>
                        </div>
                        
                        
                    <div class="mb-3">
                        <label for="JumlahBarang" class="form-label">Jumlah Barang</label>
                        <input type="number" name="JumlahBarang" id="JumlahBarang" class="form-control"
                            placeholder="Masukkan jumlah barang" value="{{ old('JumlahBarang') }}" required>
                    </div>
                    <div class="mt-3 text-center">
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function updateDescription() {
            const selectedOption = document.getElementById('barang_id').selectedOptions[0];
            const description = selectedOption.getAttribute('data-deskripsi');
            document.getElementById('Deskripsi').innerText = description || 'Muncul setelah barang dipilih';
        }
    
        // Trigger update on page load if there's an old value
        document.addEventListener('DOMContentLoaded', function() {
            updateDescription();
        });
    </script>

@endsection
