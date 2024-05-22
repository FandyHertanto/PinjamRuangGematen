@extends('layouts.mainlayout')

@section('title','Data Pengguna')

@section('content')

<h3>Data Pengguna</h3>

<div class="mt-5 d-flex justify-content-end">
    <a href="registered-user" class="btn btn-primary me-3">Pengguna Baru</a>
    <a href=""></a>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
