<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'gender' => ['nullable', Rule::in(['Laki-laki', 'Perempuan', 'Lainnya'])],
            'phone' => ['required', 'string', 'max:15'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'], // Validasi untuk gambar
            // 'role' tidak perlu divalidasi di sini karena akan diatur default 'user'
        ])->validate();

         $imagePath = null;
        // Periksa apakah ada file gambar yang diunggah
        if (isset($input['image']) && $input['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Simpan gambar ke disk 'public' di folder 'users'
            $imagePath = $input['image']->store('users', 'public');
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'gender' => $input['gender'] ?? null, // Gunakan null jika tidak ada input gender
            'phone' => $input['phone'],
            'instagram' => $input['instagram'] ?? null, // Gunakan null jika tidak ada input instagram
            'role' => 'user', // Set role default menjadi 'user' untuk registrasi publik
            'image' => $imagePath,
            'email_verified_at' => now(), // Atau null jika Anda mengimplementasikan verifikasi email
        ]);
    }
}
