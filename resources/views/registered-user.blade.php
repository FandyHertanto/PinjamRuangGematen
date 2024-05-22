@extends('layouts.mainlayout')

@section('title','Pengguna Baru')

@section('content')

<h3>Pengguna Baru</h3>

<div class="mt-5 d-flex justify-content-end">
    <a href="users" class="btn btn-primary me-3">Data Pengguna</a>
</div>

<div class='my-5'>
    <table class="table">
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

@endsection
