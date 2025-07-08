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
                            <form action="{{ route('sensordata') }}" method="POST" class="row">
                                @csrf
                                <div class="mb-3 col-lg-2">
                                    <label for="mulai"> Mulai Tanggal</label>
                                    <input type="date" class="form-control" name="start_date">
                                </div>
                                <div class="mb-3 col-lg-2">
                                    <label for="end"> Sampai Tanggal</label>
                                    <input type="date" class="form-control" name="end_date">
                                </div>
                                <div class="mb-3 col-lg-8 d-flex justify-content-between mt-auto">
                                    <button class="btn btn-info btn-md" type="submit" name="submit" value="filter"> <i class="fa fa-filter"></i> Filter </button>
                                    <button class="btn btn-danger btn-md ml-auto" type="submit" name="submit" value="dump" onclick="return confirm('Yakin Ingin Mengahpus Semua Data?')"> <i class="fa fa-trash"></i> Dump Data </button>
                                </div>

                                
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Temperatur</th>
                                            <th>Kelembapan</th>
                                            <th>Relay State</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Temperatur</th>
                                            <th>Kelembapan</th>
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