<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil terpadu.
     */
    public function show(): View
    {
        // Ambil data user yang sedang login saat ini
        $user = Auth::user(); 

        // Kembalikan ke halaman view profil
        return view('profil', compact('user')); 
    }

    /**
     * Memperbarui informasi profil (Nama & Foto) secara bersamaan.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi input nama dan file foto profil
        $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        // 2. Perbarui nama user
        $user->name = $request->name;

        // 3. Cek apakah user juga mengunggah file foto baru
        if ($request->hasFile('photo')) {
            
            // Hapus foto lama di storage jika ada berkasnya
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru ke folder 'storage/app/public/uploads'
            $path = $request->file('photo')->store('uploads', 'public');

            // Set properti kolom foto ke path yang baru
            $user->photo = $path;
        }

        // 4. Simpan seluruh perubahan ke database
        $user->save();

        return redirect()->route('profil')->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    /**
     * Menghapus akun user beserta file fotonya secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Hapus file fisik gambar dari folder storage jika ada agar tidak jadi sampah berkas
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Proses logout pengamanan sesi Laravel
        Auth::logout();

        // Hapus data user dari database secara permanen
        $user->delete();

        // Hancurkan session yang tersisa
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Akun Anda telah berhasil dihapus permanen.');
    }

    /**
     * Fungsi opsional jika Anda masih membutuhkan tombol khusus 
     * untuk menghapus fotonya saja tanpa menghapus akun.
     */
    public function deletePhoto(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->photo) {
            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
    }
}
