@extends('layouts.mainlayout')

@section('title', 'Barang')

@section('content')

<div class="card shadow">
    <div class="card-body">

        <h3 class="card-title text-center">Data Barang</h3>

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

        <div class="my-3">
            <a href="{{ route('item-add') }}" class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">+ Data Barang</a>
        </div>

        <div class="my-3">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="itemSearch" class="form-control" placeholder="Cari Barang">
        </div>

        <div id="tableContainer">
            <div class="table-responsive">
                <table class="table text-center" id="itemTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $reversedItems = $items->reverse();
                        @endphp
                        @forelse ($reversedItems as $item)
                            <tr>
                                <td>{{ $item->NamaBarang }}</td>
                                <td>{{ $item->Deskripsi }}</td>
                                <td>
                                    <form action="{{ route('item-destroy', $item->id) }}" method="POST">
                                        <a href="{{ route('item-edit', $item->id) }}" class="btn btn-warning"><i
                                                class="bi bi-pencil-square"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Data Message -->
        <div id="noDataMessage" class="text-center d-none">
            <p>Data tidak ditemukan</p>
        </div>

    </div>
</div>

@endsection





<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the search input, table container, and no data message
        const searchInput = document.getElementById('itemSearch');
        const tableContainer = document.getElementById('tableContainer');
        const noDataMessage = document.getElementById('noDataMessage');
        const table = document.getElementById('itemTable');
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



