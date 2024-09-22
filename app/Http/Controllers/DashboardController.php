<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // return view('dashboard',[
        //     'user' => 'Mohamed Fathi'
        // ]);

        return view('dashboard.index')->with([
            'user' => 'Mohamed Fathi',
        ]);

    }
}
