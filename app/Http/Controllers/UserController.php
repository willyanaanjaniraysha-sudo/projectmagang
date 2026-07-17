<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public function index(Request $request)
    {       
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        
        // WAJIB ditambahkan withTrashed() agar user terhapus sementara bisa tampil di tabel
        $users = User::withTrashed()
            ->when($search, function ($query, $search) {
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
            ->withQueryString();

        $layout = $this->getLayout();

        return view('user.index', compact('users', 'layout'));
    }

    public function create()
    {
        $layout = $this->getLayout();

        return view('user.create', compact('layout'));
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
            'email' => strtolower(str_replace(' ', '', $request->name)) . '@gmail.com',
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        UserActivity::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'action' => 'CREATE',
            'resource' => 'users',
            'ip_address' => $request->ip(),
            'device_info' => $request->userAgent(),
            'description' => 'Menambahkan user baru: '.$request->name,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Menggunakan ID manual atau mengizinkan pencarian data soft delete agar tidak 404
    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $layout = $this->getLayout();

        return view('user.edit', compact('user', 'layout'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin,super admin',
        ]);

        $user = User::withTrashed()->findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();
        UserActivity::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'action' => 'UPDATE',
            'resource' => 'users',
            'ip_address' => $request->ip(),
            'device_info' => $request->userAgent(),
            'description' => 'Memperbarui user: '.$request->name,
        ]);
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
{
    $user = User::withTrashed()->findOrFail($id);
    $user->delete();
    UserActivity::create([
        'user_id' => Auth::id(),
        'role' => Auth::user()->role,
        'action' => 'DELETE',
        'resource' => 'users',
        'ip_address' => request()->ip(),
        'device_info' => request()->userAgent(),
        'description' => 'Menghapus user: '.$user->name,
    ]);
    
    // Diubah menjadi nama route index user yang benar
    return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
}

    // Fungsi untuk menu Role Permission
    public function roleIndex()
    {
        $users = User::latest()->paginate(10);

        $layout = $this->getLayout();

        return view('role', compact('users', 'layout'));
    }

    public function adminIndex()
    {
        $users = User::where('role', 'admin')->latest()->paginate(10);

        $layout = $this->getLayout();

        return view('role', compact('users', 'layout'));
    }

    // FUNGSI RESTORE DIUBAH MENJADI MODEL USER
    public function restore($id)
    {
        // Mencari data user yang terhapus berdasarkan ID
        $user = User::withTrashed()->findOrFail($id); 
        
        // Mengembalikan data user
        $user->restore(); 
        UserActivity::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'action' => 'RESTORE',
            'resource' => 'users',
            'ip_address' => request()->ip(),
            'device_info' => request()->userAgent(),
            'description' => 'Mengembalikan user: '.$user->name,
        ]);

        return redirect()->back()->with('success', 'Akun user berhasil dikembalikan!');
    }

    /**
     * Tentukan layout berdasarkan role user yang login.
     */
    private function getLayout()
    {
        if (Auth::user()->role === 'super admin') {
            return 'layouts.mainsuperadmin';
        } elseif (Auth::user()->role === 'admin') {
            return 'layouts.mainadmin';
        }

        return 'layouts.mainuser';
    }
}