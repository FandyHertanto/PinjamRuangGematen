@extends('layouts.mainlayout')

@section('title', 'Daftar Peminjaman')

@section('content')

    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center">
                        <h3 class="text-left mb-4">Profile</h3>

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
                            <label for="NamaPengguna" class="form-label">Nama Pengguna</label>
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

                        <form action="{{ route('profile-edit') }}" method="GET">
                            <button type="submit" class="btn btn-primary">Edit Profile</button>
                        </form>



                </div>
            </div>
        </div>
    </div>



@endsection
