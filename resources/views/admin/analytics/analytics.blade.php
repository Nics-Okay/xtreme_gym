@extends('layouts.AdminLayout')

@section('title', 'Analytics - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reports.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>GYM ANALYTICS</h2> 
        </div>
        <div class="table-container">
            <div class="section-content">
                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">TOTAL MEMBERS</div>
                            <div class="menu-info">{{ $totalMembers }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-user-group"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">ACTIVE MEMBERS</div>
                            <div class="menu-info">{{ $activeMembers }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-person-walking-arrow-right"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">TOTAL GUESTS</div>
                            <div class="menu-info">{{ $totalGuests }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-user-clock"></i></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="section-content">
                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">TOTAL RESERVATIONS</div>
                            <div class="menu-info">{{ $totalReservations }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">ACTIVE STUDENTS</div>
                            <div class="menu-info">{{ $activeStudents }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-child-reaching"></i></div>
                        </div>
                    </a>
                </div>

                <div class="as-report-box">
                    <a href="#" class="menu-link">
                        <div class="page-menu">
                            <div class="menu-title">ACTIVE APPRENTICES</div>
                            <div class="menu-info">{{ $activeApprentices }}</div>
                        </div>
                        <div class="page-icon">
                            <div class="menu-icon"><i class="fa-solid fa-people-arrows"></i></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="section-content">
                <div class="as-chart">
                    <canvas id="as-chart-one" style="height: 100%; width: 100%;"></canvas>
                </div>
        
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        fetch('/monthly-membership-data')
                            .then(response => response.json())
                            .then(data => {

                                const ctx = document.getElementById('as-chart-one').getContext('2d');
                                const myBarChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: data.months,
                                        datasets: [{
                                            label: 'Monthly Memberships',
                                            data: data.data,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)',
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching membership data:', error);
                            });
                    });
                </script>

                <div class="as-chart">
                    <canvas id="as-chart-two" style="height: 100%; width: 100%;"></canvas>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        fetch('/monthly-reservation-data')
                            .then(response => response.json())
                            .then(data => {
                                const ctx = document.getElementById('as-chart-two').getContext('2d');
                                const myLineChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: data.months,
                                        datasets: [{
                                            label: 'Monthly Reservations',
                                            data: data.data,
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            fill: false,
                                            borderWidth: 2,
                                            tension: 0.1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    stepSize: 1,
                                                    callback: function(value) {
                                                        return value % 1 === 0 ? value : '';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching reservations data:', error);
                            });
                    });
                </script>

                <div class="as-chart">
                    <canvas id="as-chart-three" style="height: 100%; width: 100%;"></canvas>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        fetch('/top-user-addresses')
                            .then(response => response.json())
                            .then(data => {
                                const ctx = document.getElementById('as-chart-three').getContext('2d');
                                const myPieChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: data.labels,
                                        datasets: [{
                                            label: 'Members Addresses',
                                            data: data.data,
                                            backgroundColor: [
                                                'rgba(255, 206, 86, 1)', 
                                                'rgba(255, 99, 132, 1)', 
                                                'rgba(54, 162, 235, 1)', 
                                                'rgba(75, 192, 192, 1)', 
                                                'rgba(153, 102, 255, 1)'
                                            ],  // Solid colors for each slice
                                            borderColor: [
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)'
                                            ],  // Matching border colors
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        let percentage = Math.round((tooltipItem.raw / tooltipItem.dataset._meta[Object.keys(tooltipItem.dataset._meta)[0]].total) * 100);
                                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' (' + percentage + '%)';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching user addresses:', error);
                            });
                    });
                </script>

            </div>
        </div>
    </div>
@endsection