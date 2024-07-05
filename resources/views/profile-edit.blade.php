@extends('layouts.mainlayout')

@section('title', 'Edit Profile')

@section('content')



<div class="container">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="text-left mb-4">Perbarui Data Profile</h3>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="NamaPengguna" class="form-label">Nama Pengguna</label>
                    <input type="text" name="username" id="NamaPengguna" class="form-control" value="{{ $user->username }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">No Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                </div>

                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>

        </div>
    </div>
</div>

@endsection
