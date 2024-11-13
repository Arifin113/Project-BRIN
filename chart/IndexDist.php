<?php
session_start(); // Panggil session_start() di sini

// Logika untuk memeriksa sesi dan peran
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header('Location: ../admin/page/loginAdmin.php'); // Arahkan ke halaman loginAdmin.php
    exit; // Hentikan eksekusi skrip
}

// Sertakan header.php di sini
include 'headerDist.php';

// Pastikan koneksi ke database sudah ada di header.php
$query = mysqli_query($koneksi, "SELECT * FROM esp32_table_hcsr04_record ORDER BY date, time");

// Periksa apakah query berhasil
if (!$query) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<style>
    .content {
        padding: 5px;
    }

    .content-wrapper {
        text-align: center;
    }

    .chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        margin-left: 28px;
    }

    canvas {
        margin: 20px;
        /* Ukuran tampilan canvas */
        width: 100px;
        height: 50px;
    }
</style>

<div class="content-wrapper">
    <h2 style="text-align: center;">Grafik Ketinggian Air dari Sensor HCSR04</h2>
    <div class="chart-container">
        <canvas id="myChart" width="60" height="20" style="display: block;"></canvas>
    </div>

    <h2 style="text-align: center;">Grafik Suhu dari Sensor DS18B20</h2>
    <div class="chart-container">
        <canvas id="myChart2" width="60" height="20" style="display: block;"></canvas>
    </div>

    <h2 style="text-align: center;">Grafik Tekanan dari Sensor HX710B</h2>
    <div class="chart-container">
        <canvas id="myChart3" width="60" height="20" style="display: block;"></canvas>
    </div>

    <script>
        // Script untuk grafik Ketinggian dari Sensor HCSR04
        fetch('data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.time);
                const heightData = data.map(item => item.height);

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ketinggian Air (cm)',
                            data: heightData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 20 // Ukuran font untuk legend
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    title: (tooltipItems) => tooltipItems[0].label,
                                    label: (tooltipItem) => tooltipItem.formattedValue + ' cm'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Ketinggian Air (cm)',
                                    font: {
                                        size: 20 // Ukuran font untuk title
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 15 // Ukuran font untuk tick labels
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Warna grid
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Waktu',
                                    font: {
                                        size: 20 // Ukuran font untuk title
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 15 // Ukuran font untuk tick labels
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Warna grid
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));


        // Script untuk grafik Suhu dari Sensor DS18B20
        fetch('dataDS18B20.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.time);
                const temp1Data = data.map(item => item.temperature1);
                const temp2Data = data.map(item => item.temperature2);
                const temp3Data = data.map(item => item.temperature3);

                const ctx2 = document.getElementById('myChart2').getContext('2d');
                const myChart2 = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Temperature 1 (°C)',
                                data: temp1Data,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3, // Ukuran titik
                                borderWidth: 1 // Lebar garis
                            },
                            {
                                label: 'Temperature 2 (°C)',
                                data: temp2Data,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                borderWidth: 1
                            },
                            {
                                label: 'Temperature 3 (°C)',
                                data: temp3Data,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 20 // Ukuran font untuk legend
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    title: (tooltipItems) => tooltipItems[0].label,
                                    label: (tooltipItem) => tooltipItem.formattedValue + ' °C'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Temperature (°C)',
                                    font: {
                                        size: 20 // Ukuran font untuk title
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 15 // Ukuran font untuk tick labels
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Warna grid
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Waktu',
                                    font: {
                                        size: 20 // Ukuran font untuk title
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 15 // Ukuran font untuk tick labels
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Warna grid
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));

        // Script untuk grafik Tekanan dari Sensor HX710B
        fetch('dataHX710B.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.time);
                const pressureInputData = data.map(item => item.pressureInput);
                const pressureOutputData = data.map(item => item.pressureOutput);

                const ctx3 = document.getElementById('myChart3').getContext('2d');
                const myChart3 = new Chart(ctx3, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Tekanan Input (INWA)',
                                data: pressureInputData,
                                borderColor: 'rgba(255, 206, 86, 1)',
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                borderWidth: 1
                            },
                            {
                                label: 'Tekanan Output (INWA)',
                                data: pressureOutputData,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 20 // Ukuran font untuk legend
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    title: (tooltipItems) => tooltipItems[0].label,
                                    label: (tooltipItem) => tooltipItem.formattedValue + ' unit'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Tekanan (INWA)',
                                    font: {
                                        size: 20 // Ukuran font untuk title
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 15 // Ukuran font untuk tick labels
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Warna grid
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Waktu',
                                    font: {
                                        size: 20 // Ukuran font untuk title
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 15 // Ukuran font untuk tick labels
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.2)' // Warna grid
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    </script>

    <?php include 'footer.php'; ?>
</div>