<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        // $this->middleware (['auth'])->except('index'); // لو عاوز تعمل ميدلوير في الكنترولر
    }



    public function index()
    {
        // return view('dashboard',[
        //     'user' => 'Mohamed Fathi'
        // ]);

        $user = Auth::user();
        return view('dashboard.index')->with([
            'user' => 'Mohamed Fathi',
        ]);
    }
}
