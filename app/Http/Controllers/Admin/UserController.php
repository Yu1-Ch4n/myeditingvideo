<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Mulai dengan query dasar untuk mengambil semua user, kecuali user yang sedang login, dan urutkan berdasarkan nama
        $query = User::where('id', '!=', Auth::id())->orderBy('name');

        // Cek apakah ada parameter 'search' dalam request
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Tambahkan kondisi pencarian berdasarkan nama atau email
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('role', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%');
            });
        }

        // Ambil hasil paginasi
        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],
            'gender' => ['nullable', Rule::in(['Laki-laki', 'Perempuan', 'Lainnya'])],
            'role' => ['required', 'string', Rule::in(['admin', 'author', 'user'])],
            'image' => ['nullable', 'image', 'max:2048'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Menyimpan langsung ke disk 'public' di folder 'users'
            $imagePath = $request->file('image')->store('users', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender, // Pastikan gender disimpan
            'role' => $request->role,
            'phone' => $request->phone,
            'instagram' => $request->instagram,
            'image' => $imagePath,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        // Pencegahan agar user tidak mengedit akunnya sendiri dari halaman ini
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri dari sini. Gunakan halaman profil.');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Pencegahan agar user tidak mengupdate akunnya sendiri dari halaman ini
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat memperbarui akun Anda sendiri dari sini. Gunakan halaman profil.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(['Laki-laki', 'Perempuan', 'Lainnya'])],
            'role' => ['required', 'string', Rule::in(['admin', 'author', 'user'])],
            'image' => ['nullable', 'image', 'max:2048'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ];

        // Hanya tambahkan validasi password jika field password diisi
        if ($request->filled('password')) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        }

        $request->validate($rules);

        // Inisialisasi imagePath dengan gambar yang sudah ada atau null
        $imagePath = $user->image;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('users', 'public');
        } elseif ($request->input('remove_image')) {
            // Jika user memilih untuk menghapus gambar
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
                $imagePath = null;
            }
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'gender' => $request->gender, // Pastikan gender diperbarui
            'phone' => $request->phone,
            'instagram' => $request->instagram,
            'image' => $imagePath,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
        ];

        // Update password hanya jika field password diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Pencegahan agar user tidak bisa menghapus akunnya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}