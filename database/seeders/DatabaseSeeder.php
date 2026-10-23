<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = 'admin@dental.com';

        $admin = User::query()->firstOrNew(['email' => $email]);
        $admin->name = 'Administrador Diseñando Sonrisas';
        $admin->password = 'Dental2026!';
        $admin->email_verified_at = now();
        $admin->save();
    }
}
