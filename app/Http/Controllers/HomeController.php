<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RelayControl;
use App\Models\SensorData;
use App\Models\Config;
use Carbon\Carbon;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $relay = RelayControl::select('state')->first();
        $sensor = SensorData::latest()->take(100)->get();
        $sekarang = SensorData::latest()->first();
        return view('index', compact('relay', 'sensor', 'sekarang'));
    }

    public function viewDataSensor(Request $req)
    {   
        try {
            //code...
            if($req->isMethod('post')){
    
                if($req->submit == 'filter'){
                    $start_date = $req->start_date;
                    $end_date = $req->end_date;
                    
                    $sensor = SensorData::when($start_date && $end_date,function($query) use ($start_date,$end_date){
                        
                        $query->whereBetween('created_at',[$start_date,$end_date]);
                        
                    })->when($start_date, function($query) use ($start_date){
                        
                        $date = Carbon::parse($start_date);
                        $datepast = $date->copy()->addDays(7);
                        $query->whereBetween('created_at',[$start_date,$datepast]);
                        
                    })->when($end_date,function($query) use ($end_date){
                        
                        $date = Carbon::parse($end_date);
                        $datepast = $date->copy()->subDays(7);
                        $query->whereBetween('created_at',[$datepast,$end_date]);
                        
                    })->limit(5000)->get();
                    
                } else if($req->submit == 'dump'){
                    SensorData::truncate();
                    $sensor = SensorData::orderBy('created_at', 'Desc')->take(5000)->get();
                }
            } else {
                $sensor = SensorData::orderBy('created_at', 'Desc')->take(100)->get();
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            //throw $th;
        }
        return view('table', compact('sensor'));
    }

    public function dataSensor()
    {
        $sensor = SensorData::latest()->take(100)->get();
        return response()->json($sensor);
    }

    public function dataSekarang()
    {
        $now = Carbon::now();
        $config = Config::latest()->first();
        $sekarang = SensorData::orderBy('created_at', 'desc')->first();
        $data = [
            'sekarang' => $sekarang,
        ];

        return response()->json($data);
    }

    public function lampControll()
    {
        $relay = RelayControl::select('state')->first();
        return view('controllamp', compact('relay'));
    }
}
