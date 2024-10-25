@extends('layouts.mainlayout')

@section('title', 'Aduan')

@section('content')
    <div class="container my-5 mt-2" style="font-family: 'Rubik';">
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="mb-0">Form Aduan</h3>
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

                <form action="{{ route('kirimaduan.post') }}" method="post">
                    @csrf
                    <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id ?? '' }}">
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="NamaPeminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" name="NamaPeminjam" id="NamaPeminjam" class="form-control" 
                            value="{{ old('NamaPeminjam', $peminjaman->NamaPeminjam ?? '') }}" placeholder="Nama Peminjam" readonly style="cursor: not-allowed;">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="TimPelayanan" class="form-label">Tim Pelayanan</label>
                        <input type="text" name="TimPelayanan" id="TimPelayanan" class="form-control"
                            placeholder="Misdinar/komsos" value="{{ old('TimPelayanan', $peminjaman->TimPelayanan ?? '') }}" readonly style="cursor: not-allowed;">
                    </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="NamaRuang" class="form-label">Nama Ruang</label>
                        <input type="text" name="NamaRuang" id="NamaRuang" class="form-control"
                            value="{{ old('NamaRuang', $peminjaman->room->NamaRuang ?? '') }}" readonly style="cursor: not-allowed;">
                    </div>
                
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="TanggalPinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="TanggalPinjam" id="TanggalPinjam" class="form-control"
                                value="{{ old('TanggalPinjam', $peminjaman->TanggalPinjam ?? '') }}" readonly style="cursor: not-allowed;">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="JamPinjam" class="form-label">Jam Pinjam</label>
                            <input type="text" name="JamPinjam" id="JamPinjam" class="form-control"
                                value="{{ old('JamPinjam', (isset($peminjaman) ? \Carbon\Carbon::parse($peminjaman->JamMulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($peminjaman->JamSelesai)->format('H:i') : '')) }}" readonly style="cursor: not-allowed;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Aduan1" class="form-label">Apakah anda sudah mengembalikan seluruh alat dengan kondisi baik?</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Aduan1" id="Aduan1_yes" value="1" {{ old('Aduan1', $peminjaman->Aduan1) == '1' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="Aduan1_yes">Ya, sudah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Aduan1" id="Aduan1_no" value="0" {{ old('Aduan1', $peminjaman->Aduan1) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="Aduan1_no">Belum</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="Aduan2" class="form-label">Apakah anda sudah mematikan lampu dan AC?</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Aduan2" id="Aduan2_yes" value="1" {{ old('Aduan2', $peminjaman->Aduan2) == '1' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="Aduan2_yes">Ya, sudah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Aduan2" id="Aduan2_no" value="0" {{ old('Aduan2', $peminjaman->Aduan2) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="Aduan2_no">Belum</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Aduan3" class="form-label">Apakah ada yang perlu dilaporkan? </label>
                        <textarea name="Aduan3" id="Aduan3" class="form-control" rows="4" placeholder="Deskripsi aduan, jika tidak ada isi dengan -" required>{{ old('Aduan3', $peminjaman->Aduan3 ?? '') }}</textarea>
                    </div>

                    <div class="mt-3 d-flex">
                        <button class="btn btn-primary me-3" type="submit" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">Kirim Aduan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
