@extends('layouts.mainlayout')

@section('title', 'Data Pengguna')

@section('content')

<div class="card shadow">
    <div class="card-body">
        <h3 class="card-title text-center">Data Pengguna</h3>

        <div class="my-3 d-flex">
            <a href="registered-user" class="btn btn-primary me-3">Pengguna Baru</a>
        </div>

        <div class="my-3">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th class="col">No.</th>
                            <th class="col">Nama Pengguna</th>
                            <th class="col">No HP</th>
                            <th class="col">Email</th>
                            <th class="col">Role</th>
                            <th class="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users->reverse() as $item)
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
                                @if ($loop->first && $loop->iteration == 1)
                                    Super Admin
                                @else
                                    @if($item->role_id == 1)
                                        <form action="{{ route('users.demote', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning btn-sm">Ubah ke umat</button>
                                        </form>
                                    @elseif($item->role_id == 2)
                                        <form action="{{ route('users.promote', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-info btn-sm">Ubah ke admin</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('users.delete', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
