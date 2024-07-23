@extends('layouts.mainlayout')

@section('title', 'Daftar Peminjaman')

@section('content')

    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-left">Profile</h3>
                            <form action="{{ route('profile-edit') }}" method="GET">
                                <button type="submit" class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">Edit Profile</button>
                            </form>
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


                        <div class="mb-3">
                            <label for="NamaPengguna" class="form-label">Nama Pengguna/bidang</label>
                            <input type="text" name="NamaPengguna" id="NamaPengguna" class="form-control"
                                value="{{ Auth::user()->username }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ Auth::user()->phone }}" readonly>
                        </div>

                        



                </div>
            </div>
        </div>
    </div>



@endsection
