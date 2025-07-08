<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RelayControlController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\SensorData;
use App\Models\Config;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

URL::forceScheme('http');



Route::get('/tes',function(){
    $config = Config::latest()->first();
    // if($request->power > $limit){
        $response = Http::withHeaders([
            'Authorization'=> 'Bearer NHUpOamCMp5BI8D5JQPy6vrU2erTn01sjL4WH7HcwvOC2bmv44JXCiOJ9KQPclient653370297220100',
            ])->post('https://api.protowa.my.id/api/whatsapp/sendmessage',[
                'to' =>$config->no_hp_target, // gw tandain 
                'message' => "Tes Message",                
                'deviceId' => 'client653370297',
            ]);

        dd($response);
    // }
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/login','index')->name('login');
    Route::post('/login','checkLogin')->name('login.cek');
    Route::get('/portal','portals')->name('portal');
    Route::get('/portal-choose/{mode}','portal_mode')->name('portal.name');
}); 

    Route::controller(HomeController::class)->group(function(){
        Route::get('/', 'index')->name('dashboard');
        Route::match(['get','post'],'/view-sensor-data', 'viewDataSensor')->name('sensordata');
        Route::get('/real-sensor-data', 'dataSensor')->name('realtimedata');
        Route::get('/real-sensor-data-sekarang', 'dataSekarang')->name('realtimedatanow');
        Route::get('/lamp', 'lampControll')->name('lampControl');
    });
    
    Route::controller(SettingController::class)->group(function(){
        Route::get('/setting','index')->name('setting');
        Route::post('/penerapan-setting','store')->name('terapkansetting');
    }); 
    
    Route::controller(RelayControlController::class)->group(function(){
        Route::post('/relay-control','control')->name('relayControl');
    });