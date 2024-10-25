@extends('layouts.mainlayout')

@section('title', 'Data Pengguna')

@section('content')

<div class="card shadow-lg border-0 rounded-3" style="font-family: 'Rubik';">
    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
        <h3>Data Pengguna</h3>
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
    
        <div style="my-3 d-flex">
            <a href="{{ url('registered-user') }}" class="btn btn-primary me-3"
                style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">Aktivasi Pengguna</a>
        </div>

        <div class="my-3">
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="search" class="form-control search-input" placeholder="Cari pengguna">
            </div>

            <div id="tableContainer">
                <div class="table-responsive">
                    <table class="table text-center table-futuristic" id="userTable">
                        <thead>
                            <tr>
                                <th class="col">No.</th>
                                <th class="col">Nama Pengguna</th>
                                <th class="col">No HP</th>
                                {{-- <th class="col">Email</th> --}}
                                <th class="col">Role</th>
                                <th class="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users->reverse() as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ $item->phone }}" target="_blank">{{ $item->phone }}</a>
                                    </td>
                                    {{-- <td>{{ $item->email }}</td> --}}
                                    <td>
                                        @if ($item->role_id == 1)
                                            Admin
                                        @elseif ($item->role_id == 2)
                                            Umat
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', ['id' => $item->id]) }}"
                                            class="btn btn-success"><i class="bi bi-info-circle"></i></a>

                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-form-action="{{ route('users.delete', ['id' => $item->id]) }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="noDataMessage" class="text-center d-none">
                <p>Belum ada data pengguna</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the search input, table container, and no data message
        const searchInput = document.getElementById('search');
        const tableContainer = document.getElementById('tableContainer');
        const noDataMessage = document.getElementById('noDataMessage');
        const table = document.getElementById('userTable');
        const rows = table.querySelectorAll('tbody tr');

        // Initialize the delete modal and form
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');

        // Add event listeners to all delete buttons
        document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const formAction = this.getAttribute('data-form-action');
                deleteForm.action = formAction;
            });
        });

        // Add event listener for search input
        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();
            let hasVisibleRows = false;

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchValue));

                if (matches) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide the table and no data message based on visibility of rows
            if (hasVisibleRows) {
                tableContainer.style.display = '';
                noDataMessage.style.display = 'none';
            } else {
                tableContainer.style.display = 'none';
                noDataMessage.style.display = '';
            }
        });
    });
</script>

