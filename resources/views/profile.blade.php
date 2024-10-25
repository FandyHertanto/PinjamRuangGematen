@extends('layouts.mainlayout')

@section('title', 'Daftar Peminjaman')

@section('content')

    <div class="container">
        <div class="card shadow-lg border-0 rounded-3" style="font-family: 'Rubik';">
            <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                <h3>Profile</h3>
            </div>
            <div class="card-body">
                <!-- Area untuk notifikasi jika diperlukan -->
                <div>
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
                </div>
                <div class="d-flex justify-content-between ">
                    <!-- Tombol Edit Profile di kiri -->
                    <form action="{{ route('profile-edit') }}" method="GET" class="me-3">
                        <button type="submit" class="btn btn-primary" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">Edit Profile</button>
                    </form>
                    
                </div>
                    

                <!-- Tabel Informasi Profil -->
                <div class="table-responsive">
                    <table class="table text-center">
                        <tbody>
                            <tr>
                                <td class="text-start">
                                    <div class="mb-3">
                                        <label for="NamaPengguna" class="form-label">Nama Pengguna/bidang</label>
                                        <input type="text" name="NamaPengguna" id="NamaPengguna" class="form-control"
                                            value="{{ Auth::user()->username }}" readonly style="cursor: not-allowed;">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            value="{{ Auth::user()->email }}" readonly style="cursor: not-allowed;">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No Telepon (+62)</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ Auth::user()->phone }}" readonly style="cursor: not-allowed;" placeholder="contoh: +628212345678">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
