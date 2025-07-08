<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Monitoring Temperatur dan Suhu Kandang Ayam</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">

                <div class="sidebar-brand-text mx-3">Temperatur dan Suhu Kandang Ayam</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>


            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ request()->routeIs('lampControl') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('lampControl') }}">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Control Lampu</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('sensordata') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('sensordata') }}">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pantau Energy</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('setting') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('setting') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pengaturan Aplikasi</span>
                </a>
            </li>



            <!-- Sidebar Toggler (Sidebar) -->



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div aria-live="polite" aria-atomic="true" style="position: relative;z-index:9999;">
                <div style="position: absolute;top: 20px; right: 0;">

                    <div class="toast text-white bg-danger" id="ajaxToast" data-delay="3000">
                        <div class="toast-header">
                            <strong class="mr-auto">Notification</strong>
                            <small>Just now</small>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            Loading Message...
                        </div>
                    </div>
                    <div class="toast toastreach text-white bg-danger" id="toastReach" data-delay="3000">
                        <div class="toast-header">
                            <strong class="mr-auto">Notification</strong>
                            <small>Just now</small>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            Loading Message...
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>
                        <button type="button" class="btn btn-secondary"
                            onClick="window.location.href='{{ url('/setting') }}'">
                            <i class="fa fa-cog"></i> Pengaturan Aplikasi
                        </button>
                    </ul>

                </nav>

                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('myAreaChart').getContext('2d');
            let myLineChart;

            function fetchData(initialLoad = false) {
                $.ajax({
                    url: '/real-sensor-data',
                    method: 'GET',
                    success: function(data) {
                        const labels = data.map(item => new Date(item.created_at).toLocaleDateString());
                        const energyData = data.map(item => item.temperature);
                        const humadityData = data.map(item => item.humadity);

                        // Destroy existing chart to prevent duplicates
                        if (myLineChart) {
                            myLineChart.destroy();
                        }

                        // Initialize new Chart.js instance
                        myLineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: "Suhu",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                                        borderColor: "rgba(78, 115, 223, 1)",
                                        pointRadius: 3,
                                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                        pointBorderColor: "rgba(78, 115, 223, 1)",
                                        pointHoverRadius: 3,
                                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                        pointHitRadius: 10,
                                        pointBorderWidth: 2,
                                        data: energyData,
                                    },
                                    {
                                        label: "Kelembabpan",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(28, 200, 138, 0.05)",
                                        borderColor: "rgba(28, 200, 138, 1)",
                                        pointRadius: 3,
                                        pointBackgroundColor: "rgba(28, 200, 138, 1)",
                                        pointBorderColor: "rgba(28, 200, 138, 1)",
                                        pointHoverRadius: 3,
                                        pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                                        pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                                        pointHitRadius: 10,
                                        pointBorderWidth: 2,
                                        data: humadityData,
                                    }
                                ],
                            },
                            options: {
                                animation: {
                                    onComplete: function() {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        ctx.textAlign = 'center';
                                        ctx.fillStyle = "rgba(0, 0, 0, 0.5)";
                                        ctx.textBaseline = 'bottom';

                                        this.data.datasets.forEach(function(dataset, i) {
                                            var meta = chartInstance.controller
                                                .getDatasetMeta(i);
                                            meta.data.forEach(function(point,
                                            index) {
                                                var data = dataset.data[
                                                    index];
                                                ctx.fillText(data, point
                                                    ._model.x, point
                                                    ._model.y - 5);
                                            });
                                        });
                                    }
                                },
                                maintainAspectRatio: false,
                                layout: {
                                    padding: {
                                        left: 10,
                                        right: 25,
                                        top: 25,
                                        bottom: 0
                                    }
                                },
                                scales: {
                                    xAxes: [{
                                        time: {
                                            unit: 'date'
                                        },
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        ticks: {
                                            maxTicksLimit: 7
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            maxTicksLimit: 5,
                                            padding: 10,
                                            callback: function(value) {
                                                return value;
                                            }
                                        },
                                        gridLines: {
                                            color: "rgb(234, 236, 244)",
                                            zeroLineColor: "rgb(234, 236, 244)",
                                            drawBorder: false,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2]
                                        }
                                    }],
                                },
                                legend: {
                                    display: true
                                },
                                tooltips: {
                                    backgroundColor: "rgb(255,255,255)",
                                    bodyFontColor: "#858796",
                                    borderColor: '#dddfeb',
                                    borderWidth: 1,
                                    xPadding: 15,
                                    yPadding: 15,
                                    displayColors: true,
                                    intersect: false,
                                    mode: 'index',
                                    caretPadding: 10,
                                    callbacks: {
                                        label: function(tooltipItem, chart) {
                                            var datasetLabel = chart.datasets[tooltipItem
                                                .datasetIndex].label || '';
                                            return datasetLabel + ': ' + tooltipItem.yLabel;
                                        }
                                    }
                                }
                            }
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            }

            // Fetch data initially without animation
            fetchData(true);

            // Set interval to fetch data every 5 seconds
            setInterval(fetchData, 5000); // Ubah menjadi 5000 untuk menjalankan setiap 5 detik
        });
    </script>
    @yield('script')
</body>

</html>
