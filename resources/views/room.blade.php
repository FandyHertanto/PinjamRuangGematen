@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')

<div class="card shadow-lg border-0 rounded-3" style="font-family: 'Rubik';">
    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
        <h3>Data Ruang</h3>
    </div>
    <div class="card-body">
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
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    onclick="event.preventDefault(); setDeleteAction('{{ route('room-destroy', $room->id) }}');">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data ruang ini?
      </div>
      <div class="modal-footer">
        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function setDeleteAction(actionUrl) {
    var form = document.getElementById('deleteForm');
    form.action = actionUrl;
  }
</script>

@endsection
