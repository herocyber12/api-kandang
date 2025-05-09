<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Config::latest()->first();
        return view('setting',compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'use_timer' => 'nullable',
            'timer_start' => 'nullable',
            'timer_end' => 'nullable',
            'use_limit_rp' => 'nullable',
            'reach_limit_rp' => 'nullable',
        ]);
        $use_timer = false;
        if($request->use_timer == "on"){
            $use_timer = true;
        }
        $use_limit_rp = false;
        if($request->use_limit_rp == "on"){
            $use_limit_rp = true;
        }
        $check = Config::all();
        if($check->count() >0 ){
            Config::latest()->update([
                'no_hp_target' => $request->no_hp_target,
            ]);
        } else {

            $result = Config::create($request->all());
        }
        return redirect()->back()
                         ->with('success', 'Setting created successfully.');
    }
}
