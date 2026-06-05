<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index(Request $request)
{       
    $search = $request->input('search');
    $perPage = $request->input('per_page', 10);
    
    $users = User::when($search, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");

                  if (in_array(strtolower($search), ['user', 'admin', 'super admin'])) {
                      $q->orWhere('role', '=', $search);
                  }
            });
        })
        ->latest()
        ->paginate($perPage) 
        ->withQueryString(); // Tambahkan ini agar filter halaman tidak hilang

    return view('user.index', compact('users'));
}
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin,super admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => strtolower(str_replace(' ', '', $request->name)) . '@aspirasi.com',
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin,super admin',
        ]);

        $user->name = $request->name;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }

    // Fungsi untuk menu Role Permission
 public function roleIndex()
{
    // WAJIB pakai paginate agar fungsi ->links() di blade tidak error
    $users = \App\Models\User::latest()->paginate(10);
    
    return view('role', compact('users'));
}
public function adminIndex()
{
    // Filter hanya yang rolenya 'admin'
    $users = \App\Models\User::where('role', 'admin')->latest()->paginate(10);
    
    // Gunakan view yang sama dengan role tapi kirim data admin saja
    return view('role', compact('users'));
}
    

}
