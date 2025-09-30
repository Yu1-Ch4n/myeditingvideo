<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Import Storage facade
use App\Models\User;
use App\Models\Article; // Pastikan model Article diimport jika digunakan

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:15'], // Validasi nomor telepon
            'instagram' => ['nullable', 'string', 'max:255'], // Validasi Instagram
            'gender' => ['nullable', Rule::in(['Laki-laki', 'Perempuan', 'Lainnya'])], // Validasi gender
            'image' => ['nullable', 'image', 'max:2048'], // Validasi gambar (max 2MB)
            'current_password' => ['nullable', 'required_with:password', 'current_password'], // current_password hanya diperlukan jika password diisi
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // password bersifat opsional
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ];

        $request->validate($rules);

        // Inisialisasi imagePath dengan gambar yang sudah ada atau null
        $imagePath = $user->image;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Simpan gambar baru ke folder 'users' di disk 'public'
            $imagePath = $request->file('image')->store('users', 'public');
        } elseif ($request->input('remove_image')) {
            // Jika user memilih untuk menghapus gambar
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
                $imagePath = null;
            }
        }

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone; // Update phone
        $user->instagram = $request->instagram; // Update instagram
        $user->gender = $request->gender; // Update gender
        $user->image = $imagePath; // Update image path
        $user->address = $request->address; // Update address
        $user->city = $request->city; // Update city
        $user->province = $request->province; // Update province
        $user->postal_code = $request->postal_code; // Update postal code

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Update password hanya jika field password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect::route('admin.profile.edit')->with('success', 'Profile berhasil diperbaharui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // **LOGIKA PENGALIHAN ARTIKEL DIMULAI DI SINI**
        // 1. Temukan user admin yang akan menerima artikel
        // Anda bisa memilih admin pertama yang ditemukan, atau admin khusus (misal, superadmin)
        $adminUser = User::where('role', 'admin')->first();

        // Pastikan ada user admin untuk mengalihkan artikel
        if (!$adminUser) {
            // Ini adalah skenario error yang jarang terjadi, kecuali tidak ada admin di sistem
            return Redirect::back()->with('error', 'Cannot delete account. No admin user found to transfer articles.');
        }

        // 2. Alihkan kepemilikan artikel dari user yang dihapus ke user admin
        Article::where('user_id', $user->id)->update(['user_id' => $adminUser->id]);

        // **LOGIKA PENGALIHAN ARTIKEL SELESAI**

        // Hapus gambar profil user jika ada
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Lanjutkan dengan proses penghapusan akun user
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akun Anda telah dihapus dan artikel Anda telah ditransfer ke administrator.');
    }
}