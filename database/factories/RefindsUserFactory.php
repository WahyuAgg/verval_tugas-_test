<?php

namespace Database\Factories;

use App\Models\RefindsUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefindsUserFactory extends Factory
{
    protected $model = RefindsUser::class;

    public function definition()
    {
        return [
            'nama_akun' => $this->faker->unique()->userName,
            'nama_asli_user' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Password is hashed
            'no_telepon' => $this->faker->phoneNumber,
            'tanggal_registrasi' => $this->faker->dateTime,
            'url_foto_profil' => $this->faker->imageUrl,
            'status_akun' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'terakhir_login' => $this->faker->dateTime,
            'verification_date' => $this->faker->dateTime,
        ];
    }
}
