@extends('layouts.app')
@section('content')
    
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Riwayat Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Temperatur</th>
                                            <th>Suhu</th>
                                            <th>Relay State</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Temperatur</th>
                                            <th>Suhu</th>
                                            <th>Relay State</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php($no = 1)
                                        @foreach ($sensor as $item )
                                            
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$item->temperature}} °C</td>
                                            <td>{{$item->humadity}} %</td>
                                            <td> <span class="badge badge-pill badge-{{ $item->relay_state == 'off' ? 'danger' : 'success' }}"> {{Str::ucfirst($item->relay_state)}}</span> </td>
                                            <td>{{$item->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
@endsection