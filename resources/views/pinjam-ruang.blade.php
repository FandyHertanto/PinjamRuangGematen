@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')
    <div class="container my-5 mt-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Silahkan meminjam ruang</h3>
                    @if (session('success'))
                        <div class="alert alert-success mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mb-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <a href="{{ route('pinjam.create') }}" class="btn btn-primary">+ Pinjam Ruang</a>
                </div>

                <div id='calendar' class="border rounded p-3"></div>
            </div>
        </div>
    </div>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/locales-all.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/index.global.min.js'></script>

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
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .btn-primary {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1rem;
            }

            #calendar {
                padding: 1rem;
            }
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                locale: 'id',
                events: function(fetchInfo, successCallback, failureCallback) {
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
                        success: function(response) {
                            var events = response.map(function(event) {
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
                        error: function(error) {
                            failureCallback(error);
                        }
                    });
                },
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth'
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

                    var element = document.createElement('div');
                    element.innerHTML = `
                        <div class="custom-event-content">
                            ${JamMulai}-${JamSelesai} ${Peminjam} 
                        </div>
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
                    info.el.setAttribute('data-bs-html', 'true');
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
