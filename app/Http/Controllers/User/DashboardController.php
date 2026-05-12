<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function pengaturan()
{
    // Memanggil file pengaturan.blade.php yang ada di folder views utama
    return view('pengaturan'); 
}
public function profil()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

}
