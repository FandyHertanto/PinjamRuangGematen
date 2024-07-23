@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')

<div class="card shadow">
    <div class="card-body">

        <h3 class="card-title text-center" style="text-color: #ff0000;">Data Ruang</h3>


        <div class="my-3">
            <a href="{{ route('create') }}" class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">+ Data Ruang</a>
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

        <div class='my-3'>
            <div class="table-responsive">
                <table class='table text-center'>
                    <thead>
                        <tr>
                            <th>Nama Ruang</th>
                            <th>Kapasitas</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $reversedRooms = $rooms->reverse();
                        @endphp
                        @foreach ($reversedRooms as $room)
                        <tr>
                            <td>{{ $room->NamaRuang }}</td>
                            <td>{{ $room->Kapasitas }}</td>
                            <td><img src="{{ asset('Gambar/' . $room->Gambar) }}" width="100px"></td>
                            <td>
                                <a href="{{ route('room-edit', $room->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <button type="button" class="btn btn-danger" data-id="{{ $room->id }}" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="bi bi-trash3-fill"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal HTML -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus ruangan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var deleteModal = document.getElementById('confirmDeleteModal');
    var deleteForm = document.getElementById('deleteForm');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var roomId = button.getAttribute('data-id'); // Extract info from data-* attributes
        deleteForm.action = '/room-destroy/' + roomId; // Update form action with the room ID
    });
});
</script>
@endsection
