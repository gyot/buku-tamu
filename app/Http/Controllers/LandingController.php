<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaranaInfo;

class LandingController extends Controller
{
    public function index()
    {
        $saranaInfo = SaranaInfo::where('ditampilkan', true)->get();
        return view('landing', compact('saranaInfo'));
    }
}
