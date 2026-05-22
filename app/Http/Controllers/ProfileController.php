<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's profile page.
     */
    public function show()
    {
        // Ambil data user yang sedang login saat ini
        $user = Auth::user(); 

        // Kembalikan ke halaman view profil
        return view('profil', compact('user')); 
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        // 1. Validasi file yang diunggah
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        $user = Auth::user();

        // 2. Cek apakah user mengunggah file
        if ($request->hasFile('photo')) {
            
            // Hapus foto lama di storage jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru ke folder 'storage/app/public/avatars'
            $path = $request->file('photo')->store('uploads', 'public');

            // Update nama file foto di database menggunakan properti objek
           /** @var \App\Models\User $user */ // <-- TAMBAHKAN BARIS INI
            $user->photo = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

        public function deletePhoto()
    {
        $user = Auth::user();

        // Cek jika user memiliki catatan nama file foto di database
        if ($user->photo) {
            
            // Hapus file fisik gambar dari folder storage agar tidak menumpuk sampah berkas
            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Kosongkan kembali kolom photo di database menjadi null
            $user->photo = null;
            /** @var \App\Models\User $user */
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
    }

    
}
