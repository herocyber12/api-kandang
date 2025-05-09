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

    public function viewDataSensor()
    {
        $sensor = SensorData::orderBy('created_at', 'Desc')->take(100)->get();
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
