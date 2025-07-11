<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\RelayControl;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        $config = Config::latest()->first();
        $relay = RelayControl::first();

        $sensorData = new SensorData();
        $sensorData->temperature = $request->temperature;
        $sensorData->humadity = $request->humidity;
        $sensorData->relay_state = $relay->state;
        $sensorData->save();
        if($request->temperature <= 28){
            $lastNotifiedCold = Cache::get('last_cold_notification_time');
            if(!$lastNotifiedCold || now()->diffInMinutes($lastNotifiedCold) >= 10){
                RelayControl::updateOrCreate([], ['state' => 'on']); 
                Http::withHeaders([
                    'Authorization'=> 'Bearer NHUpOamCMp5BI8D5JQPy6vrU2erTn01sjL4WH7HcwvOC2bmv44JXCiOJ9KQPclient653370297220100',
                    ])->post('https://api.protowa.my.id/api/whatsapp/sendmessage',[
                        'to' =>$config->no_hp_target, // gw tandain 
                        'message' => "Suhu Kandang Kurang Dari 28 Drajat Lampu Hidup",                
                        'deviceId' => 'client653370297',
                    ]);
            }
            }
            
            if($request->temperature >= 32){
            $lastNotifiedHot = Cache::get('last_hot_notification_time');
            
            if(!$lastNotifiedHot || now()->diffInMinutes($lastNotifiedHot) >= 10){
                RelayControl::updateOrCreate([], ['state' => 'off']); 
                Http::withHeaders([
                    'Authorization'=> 'Bearer NHUpOamCMp5BI8D5JQPy6vrU2erTn01sjL4WH7HcwvOC2bmv44JXCiOJ9KQPclient653370297220100',
                    ])->post('https://api.protowa.my.id/api/whatsapp/sendmessage',[
                        'to' =>$config->no_hp_target, // gw tandain 
                        'message' => "Suhu Kandang Lebih Dari 32 Drajat Lampu Mati",                
                        'deviceId' => 'client653370297',
                    ]);
            }
        }

        return response()->json(['message' => 'Data stored successfully'], 200);
    }

    public function latest()
    {
        $latestData = SensorData::orderBy('created_at', 'desc')->first();
        return response()->json($latestData);
    }

    public function api_data_sensor(Request $req)
    {
        try {
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
            return response()->json([
                'status' => true,
                'code' => 2001,
                'data' => $sensor,
                'message' => 'Berhasil mengambil data'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'code' => 5001,
                'message' => 'Terjadi Kesalahan, tolong hubungi penyedia layanan'
            ]);
        }
        
    }
}
