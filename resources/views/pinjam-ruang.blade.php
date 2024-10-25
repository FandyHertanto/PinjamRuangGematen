@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')
    <div class="container my-5 mt-4" style="font-family: 'Rubik';" >
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3 mt-2 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Mau pinjam ruang apa hari ini?</h3>  
                </div>
                <div class="mb-4">
                    <a href="{{ route('pinjam.create') }}" class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">+ Pinjam Ruang</a> <br>
                </div>
                
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
                <div id='calendar' class="border rounded p-3"></div>
            </div>
        </div>
    </div>
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
    color: #000000;
    border-radius: 5px;
    transition: background-color 0.3s;
    padding: 5px;
    font-size: 14px;
    white-space: normal; /* Allow text wrapping */
    word-wrap: break-word; /* Break long words */
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
    var createRoute = @json(route('pinjam.create'));
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
            info.el.setAttribute('data-bs-html', 'true');
            var tooltip = new bootstrap.Tooltip(info.el);
            info.el._tooltip = tooltip;
        },
        eventDestroy: function(info) {
            if (info.el._tooltip) {
                info.el._tooltip.dispose();
            }
        },
        dateClick: function(info) {
            window.location.href = createRoute;
        }
    });

    calendar.render();
});

    </script>
@endsection
