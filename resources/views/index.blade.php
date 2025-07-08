@extends('layouts.app')
@section('content')
<!-- Begin Page Content -->


<div class="container-fluid">
    
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <form action="" method="post">
        @if($relay->state == "on")
            @php
                $checked = "checked";
            @endphp
        @elseif($relay->state == "off")
            @php
                $checked = "";
            @endphp
        @endif
        <label for="" class="mr-2">Status Lampu : </label>
        <input type="checkbox" id="lampSwitch" data-toggle="toggle" data-on="Lampu Nyala" data-off="Lampu Mati" data-onstyle="success" data-offstyle="danger" {{$checked}}>
    </form>
    

</div>


<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kelembapan Sekarang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="humadity">Loading...</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Suhu Sekarang
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="temperature">Loading...</div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-8">
        
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Monitor Suhu & Kelembapan</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

</div>
<!-- /.container-fluid -->
    
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });

            setInterval(function(){
                $.ajax({
                    url: '{{url("/real-sensor-data-sekarang")}}',
                    method: 'GET',
                    success: function(data){
                        $('#temperature').html(data.sekarang.temperature + " °C");
                        $('#humadity').html(data.sekarang.humadity + " %");

                    },
                });
            }
            ,1000);

            $('#lampSwitch').bootstrapSwitch();
            $('#lampSwitch').on('switchChange.bootstrapSwitch', function(event, state) {
                var status = null;
            if (state) {
                status = "on";
            } else {
                status = "off";
            }

            $.ajax({
                url: '/api/relay-control',  // Ubah URL ini sesuai dengan endpoint di server Anda
                method: 'POST',
                data: {
                    status: status
                },
                success: function(response) {
                    console.log('Status lampu berhasil diperbarui: ' + response);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ' + error);
                }
            });
        });
        });
    </script>
@endsection