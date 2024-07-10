@extends('layouts.mainlayout')

@section('title', 'Data Pengguna')

@section('content')

<div class="card shadow">
    <div class="card-body">
        <h3 class="card-title text-center">Data Pengguna</h3>

        <div class="my-3 d-flex">
            <a href="{{ url('registered-user') }}" class="btn btn-primary me-3">Aktivasi Pengguna</a>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->role_id == 1)
                                    Admin
                                @elseif ($item->role_id == 2)
                                    Umat
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', ['id' => $item->id]) }}" class="btn btn-success btn-sm"><i class="bi bi-info-circle"></i></a>

                                <form action="{{ route('users.delete', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
                                </form>
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
