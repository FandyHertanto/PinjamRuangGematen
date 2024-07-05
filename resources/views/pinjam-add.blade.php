@extends('layouts.mainlayout')

@section('title', 'Pinjam Ruang')

@section('content')

<div class="container my-5 mt-4">
    <div class="card shadow">
        <div class="card-body">
            <div class="mb-3">
                <h3 class="mb-5">Silahkan meminjam ruang</h3>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form for room booking -->
            <form action="{{ route('pinjam.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="NamaPeminjam" class="form-label">Nama Peminjam</label>
                    <input type="text" name="NamaPeminjam" id="NamaPeminjam" class="form-control" value="{{ Auth::user()->username }}" placeholder="Nama Peminjam">
                </div>

                <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">

                <div class="mb-3">
                    <label for="ruang_id" class="form-label">Nama Ruang</label>
                    <select name="ruang_id" id="ruang_id" class="form-select">
                        <option value="">Pilih Ruang</option>
                        @foreach ($ruang as $r)
                            <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>{{ $r->NamaRuang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="TanggalPinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="TanggalPinjam" id="TanggalPinjam" class="form-control" value="{{ old('TanggalPinjam') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="JamMulai" class="form-label">Jam Mulai</label>
                        <input type="time" name="JamMulai" id="JamMulai" class="form-control" value="{{ old('JamMulai') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="JamSelesai" class="form-label">Jam Selesai</label>
                        <input type="time" name="JamSelesai" id="JamSelesai" class="form-control" value="{{ old('JamSelesai') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="Deskripsi" class="form-label">Keperluan Pinjam</label>
                    <input type="text" name="Deskripsi" id="Deskripsi" class="form-control" placeholder="contoh: latihan misdinar/rapat/dll" value="{{ old('Deskripsi') }}">
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">Ajukan Peminjaman</button>
                </div>
            </form>

            <hr>

            <!-- Calendar display -->
            <div id="calendar" class="border rounded p-3"></div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/locales-all.global.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/index.global.min.js"></script>

<style>
    .fc-event {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .custom-event-content {
        text-align: left;
        background-color: rgba(107, 231, 103, 0.9);
        color: #000000;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .custom-event-contents {
        text-align: left;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            locale: 'id',
            events: '{{ route('events') }}',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth'
            },
            eventContent: function(info) {
                var NamaRuang = info.event.title;
                var JamMulai = new Date(info.event.start).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                var JamSelesai = new Date(info.event.end).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                var Persetujuan = info.event.extendedProps.persetujuan;
                var Peminjam = info.event.extendedProps.peminjam;

                var element = document.createElement('div');
                element.classList.add('custom-event-content');

                element.innerHTML = `
                    <div>
                        ${Peminjam}
                        <span>${JamMulai}-${JamSelesai}</span>
                    </div>
                `;

                return { domNodes: [element] };
            },
            eventDidMount: function(info) {
                var NamaRuang = info.event.title;
                var status = info.event.extendedProps.description;
                var JamMulai = new Date(info.event.start).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                var JamSelesai = new Date(info.event.end).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                var Persetujuan = info.event.extendedProps.persetujuan;
                var Peminjam = info.event.extendedProps.peminjam;
                var tooltipContent = `
                    <div class="custom-event-contents">
                        Peminjam : ${Peminjam}<br>
                        Ruangan  : ${NamaRuang}<br>
                        Keperluan: ${status}<br>
                        Waktu    : ${JamMulai} - ${JamSelesai}<br>
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
