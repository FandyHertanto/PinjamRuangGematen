@extends('layouts.mainlayout')

@section('title', 'Pinjam Ruang')

@section('content')

    <div class="container my-5 mt-2" style="font-family: 'Rubik';">
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="mb-0">Silahkan meminjam ruang</h3>
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

                <!-- Form for room booking -->
                <form action="{{ route('pinjam.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                
                    <div class="mb-3">
                        <label for="NamaPeminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" name="NamaPeminjam" id="NamaPeminjam" class="form-control" 
                            value="{{ old('NamaPeminjam') }}" placeholder="Nama Peminjam" required>
                    </div>
                    
                
                    <div class="mb-3">
                        <label for="TimPelayanan" class="form-label">Tim Pelayanan</label>
                        <input type="text" name="TimPelayanan" id="TimPelayanan" class="form-control"
                            placeholder="Misdinar/komsos" value="{{ old('TimPelayanan') }}" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="Jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="Jumlah" id="Jumlah" class="form-control"
                            placeholder="Jumlah peserta" value="{{ old('Jumlah') }}" required min="1">
                    </div>
                
                    <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">
                
                    <div class="mb-3">
                        <label for="ruang_id" class="form-label">Nama Ruang</label>
                        <select name="ruang_id" id="ruang_id" class="form-select" required>
                            <option value="">Pilih Ruang</option>
                            @foreach ($ruang as $r)
                                <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->NamaRuang }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="TanggalPinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="TanggalPinjam" id="TanggalPinjam" class="form-control"
                                value="{{ old('TanggalPinjam') }}" required min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="JamMulai" class="form-label">Jam Mulai</label>
                            <input type="time" name="JamMulai" id="JamMulai" class="form-control"
                                value="{{ old('JamMulai') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="JamSelesai" class="form-label">Jam Selesai</label>
                            <input type="time" name="JamSelesai" id="JamSelesai" class="form-control"
                                value="{{ old('JamSelesai') }}" required>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="Deskripsi" class="form-label">Keperluan Pinjam</label>
                        <input type="text" name="Deskripsi" id="Deskripsi" class="form-control"
                            placeholder="contoh: latihan misdinar/rapat/dll" value="{{ old('Deskripsi') }}" required>
                    </div>
                
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);" type="submit">Ajukan Peminjaman</button>
                    </div>
                </form>
                

                <hr>

                <!-- Calendar display -->
                <div id="calendar" class="border rounded p-3"></div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/index.global.min.js"></script>

    <style>
        .fc-event {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
    
        .custom-event-content {
            text-align: left;
            background-color: rgb(255, 103, 128);
            color: #000000;
            border-radius: 5px;
            transition: background-color 0.3s;
            padding: 5px;
            font-size: 14px;
            white-space: normal; /* Allow text wrapping */
            word-wrap: break-word; /* Break long words */
        }
    
        .custom-event-contents {
            text-align: left;
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
            font-size: 14px;
            white-space: normal; /* Allow text wrapping */
            word-wrap: break-word; /* Break long words */
            padding:  15px 20px;
            border-radius: 5px; /* Rounded corners for the box */
        }

        /* Atur border dan background untuk input fields pada focus */
        .form-control:focus {
            border-color: #ced4da; /* Warna border default Bootstrap */
            box-shadow: none; /* Hapus shadow pada focus */
            background-color: #ffffff; /* Warna background default */
        }
        .approved {
        background-color: rgb(87, 168, 255); /* Biru */
        }

        .pending {
            background-color: rgb(255, 193, 7); /* Kuning */
        }

        .rejected {
            background-color: rgb(255, 103, 128); /* Merah */
        }
        .canceled{
            background-color: rgb(139, 139, 139)
        }

    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            locale: 'id',
            events: function (fetchInfo, successCallback, failureCallback) {
                var start = fetchInfo.startStr;
                var end = fetchInfo.endStr;

                // Request events from server
                $.ajax({
                    url: '{{ route('events') }}',
                    dataType: 'json',
                    data: {
                        start: start,
                        end: end
                    },
                    success: function (response) {
                        var events = response.map(function (event) {
                            return {
                                id: event.id,
                                title: event.title,
                                start: event.start,
                                end: event.end,
                                description: event.description,
                                peminjam: event.peminjam,
                                persetujuan: event.persetujuan
                            };
                        });
                        successCallback(events);
                    },
                    error: function (error) {
                        failureCallback(error);
                    }
                });
            },
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            eventContent: function(info) {
            var Peminjam = info.event.extendedProps.peminjam;
            var JamMulai = new Date(info.event.start).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            var JamSelesai = new Date(info.event.end).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            var status = info.event.extendedProps.persetujuan;
            var statusClass;

            // Determine the class based on persetujuan status
            if (status === 'Disetujui') {
                statusClass = 'approved';
            } else if (status === 'Pending') {
                statusClass = 'pending';
            } else if (status === 'Ditolak') {
                statusClass = 'rejected';
            }  else if (status === 'Dibatalkan') {
                statusClass = 'canceled';
            }else {
                statusClass = ''; // Default class if no matching status
            }

            var element = document.createElement('div');
            element.className = 'custom-event-content ' + statusClass;
            element.innerHTML = `
                ${JamMulai}-${JamSelesai} ${Peminjam} 
            `;
            return { domNodes: [element] };
        },
            eventDidMount: function(info) {
                var NamaRuang = info.event.title;
                var status = info.event.extendedProps.description;
                var JamMulai = new Date(info.event.start).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
                var JamSelesai = new Date(info.event.end).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
                var Persetujuan = info.event.extendedProps.persetujuan;
                var Peminjam = info.event.extendedProps.peminjam;
                var tooltipContent = `
                <div class="custom-event-contents">
                    Peminjam : ${Peminjam}<br>
                    Ruangan  : ${NamaRuang}<br>
                    Keperluan: ${status}<br>
                    Jam    : ${JamMulai} - ${JamSelesai}<br>
                    Status   : ${Persetujuan}
                </div>
            `;

                info.el.setAttribute('data-bs-toggle', 'tooltip');
                info.el.setAttribute('title', tooltipContent);
                info.el.setAttribute('data-bs-html', 'true'); // Enable HTML content
                var tooltip = new bootstrap.Tooltip(info.el);
                info.el._tooltip = tooltip;
            },
            eventDestroy: function(info) {
                if (info.el._tooltip) {
                    info.el._tooltip.dispose();
                }
            }
        });

        calendar.render();
    });
    
</script>

@endsection