<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use App\Models\UserActivity;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil terpadu.
     */
    public function show(): View
    {
        $user = Auth::user();

        return view('profil', compact('user'));
    }

    /**
     * Memperbarui informasi profil (Nama & Foto) secara bersamaan.
     */
    public function update(Request $request): RedirectResponse
    {
       /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('photo')) {

            $oldPhoto = $user->photo;

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('uploads', 'public');

            $user->photo = $path;

            UserActivity::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'action' => empty($oldPhoto) ? 'CREATE' : 'UPDATE',
                'resource' => 'profile',
                'ip_address' => $request->ip(),
                'device_info' => $request->userAgent(),
                'description' => empty($oldPhoto)
                    ? 'Menambahkan foto profil'
                    : 'Mengubah foto profil',
            ]);
        }

        $user->save();

        return redirect()->route('profil')
            ->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    /**
     * Menghapus akun user beserta file fotonya secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        UserActivity::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'action' => 'DELETE',
            'resource' => 'profile',
            'ip_address' => $request->ip(),
            'device_info' => $request->userAgent(),
            'description' => 'Menghapus akun dan foto profil',
        ]);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Akun Anda telah berhasil dihapus permanen.');
    }

    /**
     * Menghapus foto profil saja.
     */
    public function deletePhoto(): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());

        if ($user->photo) {

            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = null;
            $user->save();

            UserActivity::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'action' => 'DELETE',
                'resource' => 'profile',
                'ip_address' => request()->ip(),
                'device_info' => request()->userAgent(),
                'description' => 'Menghapus foto profil',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Foto profil berhasil dihapus!');
    }

    /**
     * Upload atau ganti foto profil.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());

        $oldPhoto = $user->photo;

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('uploads', 'public');

        $user->photo = $path;
        $user->save();

        UserActivity::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'action' => empty($oldPhoto) ? 'CREATE' : 'UPDATE',
            'resource' => 'profile',
            'ip_address' => request()->ip(),
            'device_info' => request()->userAgent(),
            'description' => empty($oldPhoto)
                ? 'Menambahkan foto profil'
                : 'Mengubah foto profil',
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}