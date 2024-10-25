@extends('layouts.mainlayout')

@section('title', 'Daftar Peminjaman')

@section('content')

    <div class="card shadow-lg border-0 rounded-3" style="font-family: 'Rubik';">
        <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
            <h3>Daftar Peminjaman</h3>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-4">
                    <input type="text" id="globalSearch" class="form-control" placeholder="Cari di sini">
                </div>

                <div class="table-responsive">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Peminjam</th>
                                <th class="text-center">Tim Pelayanan</th>
                                <th class="text-center">Ruang</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Tanggal Pinjam</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Keperluan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rentalTableBody">
                            @foreach ($rents as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->NamaPeminjam }}</td>
                                    <td>{{ $item->TimPelayanan }}</td>
                                    <td>{{ $item->room->NamaRuang }}</td>
                                    <td>{{ $item->Jumlah }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->TanggalPinjam)) }}</td>
                                    <td>{{ substr($item->JamMulai, 0, 5) }} - {{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td>{{ $item->Deskripsi }}</td>
                                    <td id="aksi-cell-{{ $item->id }}">
                                        @if ($item->Persetujuan == 'disetujui')
                                            <span >Disetujui</span>
                                        @elseif ($item->Persetujuan == 'ditolak')
                                            <span>Ditolak</span>
                                        @elseif ($item->Persetujuan == 'dibatalkan')
                                            <span>Dibatalkan</span>
                                        @else
                                            <div class="d-flex justify-content-center">
                                                <form id="approvalForm{{ $item->id }}"
                                                    action="{{ route('rents.approve', $item->id) }}" method="POST"
                                                    class="me-2">
                                                    @csrf
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                        data-form-id="approvalForm{{ $item->id }}"
                                                        data-email="{{ $item->user->email }}"
                                                        data-item-id="{{ $item->id }}"><i
                                                            class="bi bi-check-circle"></i></button>
                                                </form>
                                                <form id="rejectForm{{ $item->id }}"
                                                    action="{{ route('rents.reject', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="button" class="btn btn-danger "
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                        data-form-id="rejectForm{{ $item->id }}"
                                                        data-email="{{ $item->user->email }}"
                                                        data-item-id="{{ $item->id }}"><i
                                                            class="bi bi-x-circle"></i></button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $rents->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #message-text,
        #reject-message-text {
            width: 100%;
            height: 150px;
            padding: 10px;
            box-sizing: border-box;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
            text-align: center;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 1em;
            border-radius: 0.25rem;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Styling untuk tombol pada kolom Aksi */
        .d-flex.justify-content-center {
            gap: 10px;
        }
    </style>

<!-- Modal for Terima -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Kirim Pesan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="messageForm">
                    <input type="hidden" id="recipient-email" name="recipient-email">
                    <input type="hidden" id="current-item-id">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Pesan:</label>
                        <textarea class="form-control" id="message-text" name="message" required>
Peminjaman anda telah disetujui, mohon untuk ditindaklanjuti
Catatan dari Admin: - (isi/hapus bila diperlukan)</textarea>
                    </div>
                </form>
                <div id="loading-message" class="text-center d-none">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p>Mengirim pesan...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="sendMessageBtn">Kirim Pesan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal for Terima -->

<!-- Modal for Tolak -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="rejectModalLabel">Kirim Pesan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectMessageForm">
                    <input type="hidden" id="reject-recipient-email" name="recipient-email">
                    <input type="hidden" id="reject-current-item-id">
                    <div class="mb-3">
                        <label for="reject-message-text" class="col-form-label">Pesan:</label>
                        <textarea class="form-control" id="reject-message-text" name="message" required>
Peminjaman anda telah ditolak, mohon untuk ditindaklanjuti
Catatan dari Admin: - (isi/hapus bila diperlukan)</textarea>
                    </div>
                </form>
                <div id="loading-reject-message" class="text-center d-none">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p>Mengirim Pesan...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="sendRejectMessageBtn">Kirim Pesan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal for Tolak -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));

    // Handle click on Terima button
    document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#exampleModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const formId = this.getAttribute('data-form-id');
            const email = this.getAttribute('data-email');
            const itemId = this.getAttribute('data-item-id');

            // Fill modal fields
            document.getElementById('recipient-email').value = email;
            document.getElementById('current-item-id').value = itemId;

            // Show modal
            modal.show();
        });
    });

    // Handle click on Tolak button
    document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#rejectModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const formId = this.getAttribute('data-form-id');
            const email = this.getAttribute('data-email');
            const itemId = this.getAttribute('data-item-id');

            // Fill modal fields
            document.getElementById('reject-recipient-email').value = email;
            document.getElementById('reject-current-item-id').value = itemId;

            // Show modal
            rejectModal.show();
        });
    });

    // Handle sending approve message
    document.getElementById('sendMessageBtn').addEventListener('click', function() {
        const recipient = document.getElementById('recipient-email').value;
        const message = document.getElementById('message-text').value;
        const itemId = document.getElementById('current-item-id').value;

        // Show loading indicator
        document.getElementById('loading-message').classList.remove('d-none');

        fetch('/send-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    recipient: recipient,
                    message: message,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);

                // Hide loading indicator and modal after sending the message
                document.getElementById('loading-message').classList.add('d-none');
                modal.hide();

                // Change the column "Aksi" text to "Disetujui" and update the database
                fetch(`/rents/approve/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            id: itemId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const aksiCell = document.getElementById(`aksi-cell-${itemId}`);
                        aksiCell.innerHTML = 'Disetujui';

                        // Show success message
                        alert('Pesan berhasil dikirim');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengubah status. Silakan coba lagi.');
                    });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengirim pesan. Silakan coba lagi.');
                document.getElementById('loading-message').classList.add('d-none');
            });
    });

    // Handle sending reject message
    document.getElementById('sendRejectMessageBtn').addEventListener('click', function() {
        const recipient = document.getElementById('reject-recipient-email').value;
        const message = document.getElementById('reject-message-text').value;
        const itemId = document.getElementById('reject-current-item-id').value;

        // Show loading indicator
        document.getElementById('loading-reject-message').classList.remove('d-none');

        fetch('/send-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    recipient: recipient,
                    message: message,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);

                // Hide loading indicator and modal after sending the message
                document.getElementById('loading-reject-message').classList.add('d-none');
                rejectModal.hide();

                // Change the column "Aksi" text to "Ditolak" and update the database
                fetch(`/rents/reject/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            id: itemId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const aksiCell = document.getElementById(`aksi-cell-${itemId}`);
                        aksiCell.innerHTML = 'Ditolak';

                        // Show success message
                        alert('Pesan berhasil dikirim');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengubah status. Silakan coba lagi.');
                    });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengirim pesan. Silakan coba lagi.');
                document.getElementById('loading-reject-message').classList.add('d-none');
            });
    });

    // Handle modal closure
    document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function() {
        // Clear modal fields
        document.getElementById('recipient-email').value = '';
        document.getElementById('message-text').value = '';
    });

    document.getElementById('rejectModal').addEventListener('hidden.bs.modal', function() {
        // Clear modal fields
        document.getElementById('reject-recipient-email').value = '';
        document.getElementById('reject-message-text').value = '';
    });

    // Global search functionality
    document.getElementById('globalSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#rentalTableBody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const isVisible = Array.from(cells).some(cell => cell.textContent.toLowerCase()
                .includes(query));
            row.style.display = isVisible ? '' : 'none';
        });
    });
});

    </script>

@endsection
