@extends('layouts.mainlayout')

@section('title', 'Daftar Peminjaman')

@section('content')

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
            <h3>Daftar Peminjaman</h3>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-4">
                    <input type="text" id="globalSearch" class="form-control" placeholder="Cari di sini">
                </div>

                <div class="table-responsive">
                    <table class="table text-center">

                        <thead>
                            <tr>
                                <th class="col">No.</th>
                                <th class="col">Peminjam</th>
                                <th class="col">Tim Pelayanan</th>
                                <th class="col">Ruang</th>
                                <th class="col">Jumlah</th>
                                <th class="col">Tanggal Pinjam</th>
                                <th class="col">Jam</th>
                                <th class="col">Keperluan</th>
                                <th class="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rentalTableBody">
                            @php $i = 1; @endphp
                            @foreach ($rents as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->NamaPeminjam }}</td>
                                    <td>{{ $item->TimPelayanan }}</td>
                                    <td>{{ $item->room->NamaRuang }}</td>
                                    <td>{{ $item->Jumlah }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->TanggalPinjam)) }}</td>
                                    <td>{{ substr($item->JamMulai, 0, 5) }}-{{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td>{{ $item->Deskripsi }}</td>
                                    <td id="aksi-cell-{{ $item->id }}">
                                        @if ($item->Persetujuan == 'disetujui')
                                            Disetujui
                                        @elseif ($item->Persetujuan == 'ditolak')
                                            Ditolak
                                        @elseif ($item->Persetujuan == 'dibatalkan')
                                            Dibatalkan
                                        @else
                                            <form id="approvalForm{{ $item->id }}"
                                                action="{{ route('rents.approve', $item->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    data-form-id="approvalForm{{ $item->id }}"
                                                    data-email="{{ $item->user->email }}"
                                                    data-item-id="{{ $item->id }}"><i
                                                        class="bi bi-check-circle"></i></button>
                                            </form>
                                            <form id="rejectForm{{ $item->id }}"
                                                action="{{ route('rents.reject', $item->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('POST')
                                                <button type="button" class="btn btn-danger reject-btn"
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                    data-form-id="rejectForm{{ $item->id }}"
                                                    data-email="{{ $item->user->email }}"
                                                    data-item-id="{{ $item->id }}"><i
                                                        class="bi bi-x-circle"></i></button>
                                            </form>
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
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label"></label>
                            <input type="text" class="form-control" id="recipient-name" name="recipient-name" readonly
                                hidden>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="sendMessageBtn">Kirim Pesan</button>
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
                        <div class="mb-3">
                            <label for="reject-recipient-name" class="col-form-label"></label>
                            <input type="text" class="form-control" id="reject-recipient-name" name="recipient-name"
                                readonly hidden>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="sendRejectMessageBtn">Kirim Pesan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal for Tolak -->

    <style>
        #message-text,
        #reject-message-text {
            width: 100%;
            height: 150px;
            /* Adjust height as needed */
            padding: 10px;
            box-sizing: border-box;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 1.25rem;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));

            // Handle click on Terima button
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const formId = this.getAttribute('data-form-id');
                    const email = this.getAttribute('data-email');
                    const itemId = this.getAttribute('data-item-id');

                    // Fill modal fields
                    document.getElementById('recipient-name').value = email;
                    document.getElementById('recipient-email').value = email;
                    document.getElementById('current-item-id').value = itemId;

                    // Show modal
                    modal.show();
                });
            });

            // Handle click on Tolak button
            document.querySelectorAll('.reject-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const formId = this.getAttribute('data-form-id');
                    const email = this.getAttribute('data-email');
                    const itemId = this.getAttribute('data-item-id');

                    // Fill modal fields
                    document.getElementById('reject-recipient-name').value = email;
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
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);

                        // Hide modal after sending the message
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
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                const aksiCell = document.getElementById(`aksi-cell-${itemId}`);
                                aksiCell.innerHTML = 'Disetujui';

                                // Show success message
                                alert('Pesan berhasil dikirim ');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengubah status. Silakan coba lagi.');
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    });
            });

            // Handle sending reject message
            document.getElementById('sendRejectMessageBtn').addEventListener('click', function() {
                const recipient = document.getElementById('reject-recipient-email').value;
                const message = document.getElementById('reject-message-text').value;
                const itemId = document.getElementById('reject-current-item-id').value;

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
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);

                        // Hide modal after sending the message
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
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
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
                    });
            });

            // Handle modal closure
            document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function() {
                // Clear modal fields
                document.getElementById('recipient-name').value = '';
                document.getElementById('recipient-email').value = '';
                document.getElementById('message-text').value = '';
            });

            document.getElementById('rejectModal').addEventListener('hidden.bs.modal', function() {
                // Clear modal fields
                document.getElementById('reject-recipient-name').value = '';
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
