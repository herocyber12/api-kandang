@extends('layouts.app')
@section('content')
@php
    $settings=null;
@endphp
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengaturan Aplikasi</h6>
            </div>
            <div class="card-body">
            <form action="{{route('terapkansetting')}}" method="POST">
            @csrf

            <div class="row">
                
            <div class="col-xl-12 d-flex">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <strong>Nomor Hp Anda:</strong><i class="fa fa-question ml-3" id="quest"></i>
                            <input type="text" name="no_hp_target" class="form-control" value="{{ $setting->no_hp_target ?? '' }}" placeholder="Contoh : 628123456789" require>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary d-block col-xl-12">Terapkan</button>
                </div>
            </div>

        </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("[name='use_timer']").bootstrapSwitch();
            $("[name='use_limit_rp']").bootstrapSwitch();

            $("[name='use_timer']").on('switchChange.bootstrapSwitch', function(event, state) {
                $("[name='timer_start']").prop('disabled', !state);
                $("[name='timer_end']").prop('disabled', !state);
            });
            $("[name='use_limit_rp']").on('switchChange.bootstrapSwitch', function(event, state) {
                $("[name='reach_limit_rp']").prop('disabled', !state);
            });

            $("#quest").click(function(){
                $("#ajaxToast .toast-body").html("Nomor Hp Digunakan Untuk Mengirim Notifikasi Ke Anda");

                $("#ajaxToast").toast('show');
            });
        });
    </script>
@endsection