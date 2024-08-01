@extends('layouts.mainlayout')

@section('title', 'Keranjang Peminjaman')

@section('content')
    <div class="container">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                <h3>Keranjang Peminjaman</h3>
            </div>
            <div class="card-body">
                

                <!-- Search Bar for Global Search -->
                <div class="mb-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari di sini">
                </div>

                <div class="table-responsive">
                    <table class="table text-center" id="rentalTable">
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

                        <thead>
                            <tr>
                                <th class="col">No.</th>
                                <th class="col">Tim Pelayanan</th>
                                <th class="col">Ruang</th>
                                <th class="col">Jumlah</th>
                                <th class="col">Tanggal Pinjam</th>
                                <th class="col">Mulai</th>
                                <th class="col">Selesai</th>
                                <th class="col">Keperluan</th>
                                <th class="col">Status</th>
                                <th class="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $now = \Carbon\Carbon::now();
                            @endphp
                            @foreach ($peminjamans as $item)
                                @php
                                    $tanggalPinjam = \Carbon\Carbon::parse($item->TanggalPinjam)->format('Y-m-d'); // Format date for comparison
                                    $startDateTime = \Carbon\Carbon::parse($item->TanggalPinjam)->setTimeFromTimeString(
                                        $item->JamMulai,
                                    );
                                    $endDateTime = \Carbon\Carbon::parse($item->TanggalPinjam)->setTimeFromTimeString(
                                        $item->JamSelesai,
                                    );
                                @endphp
                                <tr data-date="{{ $tanggalPinjam }}"> <!-- Add data attribute for filtering -->
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->TimPelayanan }}</td>
                                    <td>{{ $item->room->NamaRuang }}</td>
                                    <td>{{ $item->Jumlah }}</td>
                                    <td>{{ $item->TanggalPinjam }}</td>
                                    <td>{{ substr($item->JamMulai, 0, 5) }}</td>
                                    <td>{{ substr($item->JamSelesai, 0, 5) }}</td>
                                    <td>{{ $item->Deskripsi }}</td>
                                    <td>
                                        @if ($item->Persetujuan == 'disetujui')
                                            @if (Carbon\Carbon::parse($item->TanggalPinjam)->isPast())
                                                Selesai
                                            @else
                                                Disetujui
                                            @endif
                                        @elseif ($item->Persetujuan == 'ditolak')
                                            Ditolak
                                        @elseif ($item->Persetujuan == 'pending')
                                            Pending
                                        @elseif ($item->Persetujuan == 'dibatalkan')
                                            Dibatalkan
                                        @else
                                            Menunggu
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->Persetujuan == 'disetujui')
                                            @if ($item->StatusPinjam == 'dibatalkan')
                                                Dibatalkan
                                            @else
                                                @if ($now->lessThan($startDateTime))
                                                    <form action="{{ route('rents.cancel', $item->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Batal</button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-success selesai-btn"
                                                        data-bs-toggle="modal" data-bs-target="#feedbackModal"
                                                        data-item-id="{{ $item->id }}"
                                                        id="sendMessageButton">Aduan</button>
                                                @endif
                                            @endif
                                        @else
                                            <!-- No action buttons for other statuses -->
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $peminjamans->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('send.feedback.email') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Kirim Pesan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="current-item-id" name="current-item-id">
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
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
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('rentalTable');
            const rows = table.querySelectorAll('tbody tr');
            const tableContainer = document.querySelector('.table-responsive');
            const noDataMessage = document.getElementById('noDataMessage');

            searchInput.addEventListener('input', function() {
                const searchValue = searchInput.value.toLowerCase();
                let hasVisibleRows = false;

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase()
                        .includes(searchValue));

                    if (matches) {
                        row.style.display = '';
                        hasVisibleRows = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (hasVisibleRows) {
                    tableContainer.style.display = '';
                    noDataMessage.style.display = 'none';
                } else {
                    tableContainer.style.display = 'none';
                    noDataMessage.style.display = '';
                }
            });

            const selesaiButtons = document.querySelectorAll('.selesai-btn');
            selesaiButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    document.getElementById('current-item-id').value = itemId;
                });
            });

            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const messageForm = document.getElementById('messageForm');
            const loading = document.getElementById('loading');

            sendMessageBtn.addEventListener('click', function() {
                messageForm.style.display = 'none';
                loading.style.display = 'block';

                setTimeout(() => {
                    messageForm.submit();
                }, 1000);
            });

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

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    });
            });
        });
    </script>
@endsection
