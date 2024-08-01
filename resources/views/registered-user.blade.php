@extends('layouts.mainlayout')

@section('title','Aktivasi Pengguna')

@section('content')

<div class="card shadow-lg border-0 rounded-3">
    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
        <h3>Aktivasi Pengguna</h3>
    </div>
    <div class="card-body">

        

         @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="my-3 d-flex">
            <a href="users" class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">Kembali ke Data Pengguna</a>
        </div>

        <div class='my-3'>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $registeredUsers = $registeredUsers->reverse(); // Balik urutan array
                    @endphp

                    @foreach ($registeredUsers as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{$item->email}}</td>
                        <td>
                            @if($item->role_id == 1)
                                Admin
                            @elseif($item->role_id == 2)
                                Umat
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('users.approve', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success me-3">Terima</button>
                            </form>
                            <form action="{{ route('users.reject', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
