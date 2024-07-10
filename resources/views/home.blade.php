@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')
    <div class="container my-5 mt-4">
        <div class="card shadow">
            <div class="card-body">
                <div class=" mb-3">
                    <h3 class="mb-5">Silahkan meminjam ruang</h3>

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

                    <a href="{{ route('pinjam.create') }}" class="mb-3 btn btn-primary">+ Pinjam Ruang</a>
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

                <div id='calendar' class="border rounded p-3"></div>
            </div>
        </div>
    </div>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/locales-all.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/index.global.min.js'></script>

    <style>
        .fc-event {
            background-color: transparent !important;
            /* Menghilangkan background default */
            border: none !important;
            /* Menghilangkan border default */
            box-shadow: none !important;
            /* Menghilangkan box-shadow default */
        }

        .custom-event-content {
            text-align: left;
            background-color: rgba(107, 231, 103, 0.9);
            color: #000000;
            border-radius: 5px;
            transition: background-color 0.3s;
            /* Tambahkan efek transisi untuk perubahan background */
        }

        .custom-event-contents {
            text-align: left;
            background-color: transparent !important;
            /* Menghilangkan background default */
            border: none !important;
            /* Menghilangkan border default */
            box-shadow: none !important;
            /* Menghilangkan box-shadow default */
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

                    var element = document.createElement('div');
                    element.classList.add('custom-event-content');

                    element.innerHTML = `
                    <div>
                        ${Peminjam}
                        <span>${JamMulai}-${JamSelesai}</span>
                    </div>
                `;

                    return {
                        domNodes: [element]
                    };
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
