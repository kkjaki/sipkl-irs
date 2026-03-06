<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Industry;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // GANTI INI DENGAN EMAIL LOGIN-MU!
        $userEmail = 'tanu@gmail.com';

        // 1. Pastikan akunmu ada dan punya role owner
        $user = User::firstOrCreate(
            ['email' => $userEmail],
            [
                'name' => 'Tanu (Owner)',
                'password' => Hash::make('password'),
            ]
        );
        $user->update(['role' => 'owner']);

        // 2. Bikin Industri, catat ID kamu sebagai bosnya (owner_id)
        $industry = Industry::updateOrCreate(
            ['owner_id' => $user->id], 
            [
                'name'     => 'PT Teknologi Maju Bersama',
                'address'  => 'Jl. Pahlawan No. 123, Kota Surakarta',
                'phone'    => '081234567890',
            ]
        );

        $this->command->info('Sukses! Akun Owner dan Industri sudah terhubung dengan benar tanpa error!');
    }
}