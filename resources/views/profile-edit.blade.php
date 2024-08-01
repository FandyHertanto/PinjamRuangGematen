@extends('layouts.mainlayout')

@section('title', 'Edit Profile')

@section('content')



    <div class="container">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                <h3>Perbarui Data Profile</h3>
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
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="NamaPengguna" class="form-label">Nama Pengguna</label>
                        <input type="text" name="username" id="NamaPengguna" class="form-control"
                            value="{{ $user->username }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="{{ $user->phone }}">
                    </div>

                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-success">Perbarui</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </div>

@endsection
