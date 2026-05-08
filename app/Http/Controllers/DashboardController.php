<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Tambahkan ini jika merah di bagian 'extends Controller'
use Illuminate\Support\Facades\Auth; // Opsional, tapi bagus untuk ada

class DashboardController extends Controller
{
    public function index()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    return view('dashboard', compact('user'));
}


}
