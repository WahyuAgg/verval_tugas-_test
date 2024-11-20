<?php

namespace Database\Factories;

use App\Models\RefindsUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;


class RefindsUserFactory extends Factory
{
    protected $model = RefindsUser::class;

    public function definition()
    {
                // Ambil semua file di folder storage/app/public/pfp_images
                $files = Storage::files('public/pfp_images');

                // Pilih file secara acak
                $randomFile = $files[array_rand($files)];

                // Ubah path menjadi URL yang sesuai untuk disimpan di database
                // Menghapus prefix 'public/' agar menjadi 'storage/...'
                $urlPfpImages = str_replace('public/', 'storage/', $randomFile);
        return [
            'nama_akun' => $this->faker->unique()->userName,
            'nama_asli_user' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Password is hashed
            'no_telepon' => $this->faker->phoneNumber,
            'tanggal_registrasi' => $this->faker->dateTime,
            'url_foto_profil' => $urlPfpImages,
            'status_akun' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'terakhir_login' => $this->faker->dateTime,
            'verification_date' => $this->faker->dateTime,
        ];
    }
}
