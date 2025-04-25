<div class="overview two">
    <canvas id="revenueChart" style="height: 100%; width: 100%;"></canvas>
    <button class="toggle-visibility" style="position: absolute; top: 10px; right: 10px; border: none; background: none; cursor: pointer; color: #4b5563;">
        <i id="eye-icon" class="fa fa-eye"></i>
    </button>
</div>

<!-- Chart Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/revenue-summary')
            .then(response => response.json())
            .then(data => {
                const maxRevenue = Math.max(...data.revenues);
                const roundedMax = Math.ceil(maxRevenue / 1000) * 1000; // Round up to the nearest thousand
                const stepSize = Math.ceil(roundedMax / 10 / 1000) * 1000;

                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.months,
                        datasets: [{
                            label: 'Revenue',
                            data: data.revenues,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            tension: 0.4, // Smooth curve
                        }]
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Xtreme Revenue Summary ({{ $year }})',
                                font: {
                                    color: 'black',
                                    size: 18,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: stepSize // Use the calculated step size
                                },
                                title: {
                                    display: true,
                                    text: 'Monthly Revenue',
                                    font: {
                                        color: 'black',
                                        size: 14,
                                        weight: 'light'
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month',
                                    font: {
                                        color: 'black',
                                        size: 14,
                                        weight: 'light'
                                    }
                                }
                            }
                        }
                    }
                });
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector('.toggle-visibility');
        const revenueData = document.getElementById('revenueChart');
        const eyeIcon = document.getElementById('eye-icon');


        // Check localStorage to see if blur state should be retained
        if (localStorage.getItem('blurState') === 'true') {
            revenueData.classList.add('blur');
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }

        toggleButton.addEventListener('click', function() {
            if (revenueData.classList.contains('blur')) {
                // Remove blur effect
                revenueData.classList.remove('blur');
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                localStorage.setItem('blurState', 'false');
            } else {
                // Apply blur effect
                revenueData.classList.add('blur');
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                localStorage.setItem('blurState', 'true');
            }
        });
    });
</script>