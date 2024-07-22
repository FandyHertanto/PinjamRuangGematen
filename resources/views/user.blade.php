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
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="search" class="form-control" placeholder="Cari pengguna">
            </div>

            <div id="tableContainer">
                <div class="table-responsive">
                    <table class="table text-center" id="userTable">
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
                            @forelse ($users->reverse() as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->username }}</td>
                                <td>
                                    <a href="https://wa.me/{{ $item->phone }}" target="_blank">{{ $item->phone }}</a>
                                </td>
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
                            @empty
                            
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            <div id="noDataMessage" class="text-center d-none">
                <p>Data tidak ditemukan</p>
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

