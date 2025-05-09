<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\RelayControl;

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
            RelayControl::updateOrCreate([], ['state' => 'on']); 
            Http::withHeaders([
                'Authorization'=> 'Bearer NHUpOamCMp5BI8D5JQPy6vrU2erTn01sjL4WH7HcwvOC2bmv44JXCiOJ9KQPclient653370297220100',
                ])->post('https://api.protowa.my.id/api/whatsapp/sendmessage',[
                    'to' =>$config->no_hp_target, // gw tandain 
                    'message' => "Suhu Kandang Kurang Dari 28 Drajat Lampu Hidup",                
                    'deviceId' => 'client653370297',
                ]);
        }

        if($request->temperature >= 32){
            RelayControl::updateOrCreate([], ['state' => 'off']); 
            Http::withHeaders([
                'Authorization'=> 'Bearer NHUpOamCMp5BI8D5JQPy6vrU2erTn01sjL4WH7HcwvOC2bmv44JXCiOJ9KQPclient653370297220100',
                ])->post('https://api.protowa.my.id/api/whatsapp/sendmessage',[
                    'to' =>$config->no_hp_target, // gw tandain 
                    'message' => "Suhu Kandang Lebih Dari 32 Drajat Lampu Mati",                
                    'deviceId' => 'client653370297',
                ]);
        }

        return response()->json(['message' => 'Data stored successfully'], 200);
    }

    public function latest()
    {
        $latestData = SensorData::orderBy('created_at', 'desc')->first();
        return response()->json($latestData);
    }
}
