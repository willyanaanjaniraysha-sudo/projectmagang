<?php

namespace App\Http\Controllers; // Tambahkan \User di sini

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    public function pengaturan()
    {
        return view('pengaturan');
    }
 
    public function profil()
{
    return view('profil');
}
}
