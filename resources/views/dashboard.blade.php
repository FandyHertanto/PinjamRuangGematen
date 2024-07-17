@extends('layouts.mainlayout')

@section('title', 'dashboard')

@section('content')

    <div class="card shadow">
        <div class="card-body">
            <h3 class="mt-3">Selamat Datang Kembali, {{ Auth::user()->username }}</h3>

            <div class="dropdown mb-4">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownRoom" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @if (!empty($selected_room_name))
                        {{ $selected_room_name }}
                    @else
                        Pilih Ruangan
                    @endif
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownRoom">
                    <li>
                        <a class="dropdown-item" href="#" data-room-id="all">Semua Ruangan</a>
                    </li>
                    @foreach ($ruangan as $room)
                        <li>
                            <a class="dropdown-item" href="#"
                                data-room-id="{{ $room->id }}">{{ $room->NamaRuang }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if (!empty($available_years))
                <div class="dropdown mb-4">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownYear"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if (!empty($selected_year))
                            {{ $selected_year }}
                        @else
                            Pilih Tahun
                        @endif
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="dropdownYear">
                        @foreach ($available_years as $year)
                            <li>
                                <a class="dropdown-item" href="#"
                                    data-year="{{ $year }}">{{ $year }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="col-lg-12">
                <canvas id="barChart" width="800" height="400"></canvas>
            </div>

            <div class="dropdown mb-4">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMonth" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @if (!empty($selected_month))
                        {{ $selected_month }}
                    @else
                        Pilih Bulan
                    @endif
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMonth">
                    @foreach ($available_months as $month)
                        <li>
                            <a class="dropdown-item" href="#" data-month="{{ $month }}">{{ $month }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <h5 class="card-title text-center">Data Peminjaman </h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead id="default-head">
                        <tr>
                            <th class="col">Peminjam</th>
                            <th class="col">Total Peminjaman</th>
                        </tr>
                    </thead>
                    <thead id="expanded-head" style="display: none;">
                        <tr>
                            <th class="col">Peminjam</th>
                            <th class="col">Total Peminjaman</th>
                            <th class="col">Ruang</th>
                            <th class="col">Tanggal Pinjam</th>
                            <th class="col">Jam</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($rents as $userRent)
                            @foreach ($userRent['items'] as $item)
                                <tr>
                                    @if ($loop->first)
                                        <td rowspan="{{ $userRent['total'] }}">{{ $userRent['user']->username }}</td>
                                        <td rowspan="{{ $userRent['total'] }}" class="toggle-details clickable"
                                            data-user-id="{{ $userRent['user']->id }}">
                                            {{ $userRent['total'] }}
                                        </td>
                                    @endif
                                    <td class="details details-{{ $userRent['user']->id }}">{{ $item->room->NamaRuang }}</td>
                                    <td class="details details-{{ $userRent['user']->id }}">{{ $item->TanggalPinjam }}</td>
                                    <td class="details details-{{ $userRent['user']->id }}">
                                        {{ substr($item->JamMulai, 0, 5) }} - {{ substr($item->JamSelesai, 0, 5) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .clickable {
            cursor: pointer;
        }

        .clickable:hover {
            background-color: #f1f1f1;
        }
    </style>

    <script>
document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bulan), // Initialize with all unique months
                datasets: @json([]) // Initialize with empty datasets
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += Math.round(context.parsed.y); // Round to nearest whole number
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0, // Display only whole numbers on Y axis
                        ticks: {
                            stepSize: 1 // Ensure ticks are displayed as whole numbers
                        }
                    }
                }
            }
        });

        // Add event listener for dropdown items (Room)
        var dropdownRoomItems = document.querySelectorAll('.dropdown-item[data-room-id]');
        dropdownRoomItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                var roomId = event.target.getAttribute('data-room-id');
                var roomName = event.target.textContent.trim();

                // Update button text to selected room name
                var dropdownButton = document.getElementById('dropdownRoom');
                dropdownButton.textContent = roomName;

                // Set active class for selected room
                document.querySelectorAll('.dropdown-item[data-room-id]').forEach(function(el) {
                    el.classList.remove('active');
                });
                event.target.classList.add('active');

                // Fetch data for the selected room(s) and current year
                if (roomId === 'all') {
                    fetchDataForAllRooms(selectedYear());
                } else {
                    fetchData(roomId, selectedYear());
                }
            });
        });

        // Add event listener for dropdown items (Year)
        var dropdownYearItems = document.querySelectorAll('.dropdown-item[data-year]');
        dropdownYearItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                var year = event.target.getAttribute('data-year');

                // Update button text to selected year
                var dropdownButton = document.getElementById('dropdownYear');
                dropdownButton.textContent = year;

                // Set active class for selected year
                document.querySelectorAll('.dropdown-item[data-year]').forEach(function(el) {
                    el.classList.remove('active');
                });
                event.target.classList.add('active');

                // Fetch data for the selected year and current room
                fetchData(selectedRoomId(), year);
            });
        });

        // Helper function to get the selected room ID
        function selectedRoomId() {
            var activeRoom = document.querySelector('.dropdown-item[data-room-id].active');
            return activeRoom ? activeRoom.getAttribute('data-room-id') : null;
        }

        // Helper function to get the selected year
        function selectedYear() {
            var activeYear = document.querySelector('.dropdown-item[data-year].active');
            return activeYear ? activeYear.getAttribute('data-year') : null;
        }

        // Fetch data function for single room
        function fetchData(roomId, year) {
            fetch('/getChartData/' + roomId + '?year=' + year) // Append year as query parameter
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update chart with new data
                    myChart.data.datasets = data.datasets; // Update datasets
                    myChart.update();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Fetch data function for all rooms
        function fetchDataForAllRooms(year) {
            fetch('/getChartData/all?year=' + year) // Request data for all rooms
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update chart with new data
                    myChart.data.datasets = data.datasets; // Update datasets
                    myChart.update();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
            function updateTableData(data) {
                var tableBody = document.getElementById('table-body');
                tableBody.innerHTML = ''; // Clear existing table body content

                data.forEach(function(rent) {
                    rent.items.forEach(function(item, index) {
                        var row = '<tr>';
                        if (index === 0) {
                            row += '<td rowspan="' + rent.total + '">' + rent.user.username +
                                '</td>';
                            row += '<td rowspan="' + rent.total +
                                '" class="toggle-details clickable" data-user-id="' + rent.user.id +
                                '">' + rent.total + '</td>';
                        }
                        row += '<td class="details details-' + rent.user.id + '">' + item.room.NamaRuang + '</td>';
                        row += '<td class="details details-' + rent.user.id + '">' + item.TanggalPinjam + '</td>';
                        row += '<td class="details details-' + rent.user.id + '">' + item.JamMulai.substr(0, 5) + ' - ' + item.JamSelesai.substr(0, 5) + '</td>';
                        row += '</tr>';
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                });
            }
        });

        // dropdown bulan
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownMonthItems = document.querySelectorAll('.dropdown-item[data-month]');
            dropdownMonthItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    var month = event.target.getAttribute('data-month');

                    var dropdownButton = document.getElementById('dropdownMonth');
                    dropdownButton.textContent = month;

                    document.querySelectorAll('.dropdown-item[data-month]').forEach(function(el) {
                        el.classList.remove('active');
                    });
                    event.target.classList.add('active');

                    fetchData(month);
                });
            });

            function fetchData(month) {
                fetch('/getRentData/' + month)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateTableData(data);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }
        });

    </script>

@endsection
