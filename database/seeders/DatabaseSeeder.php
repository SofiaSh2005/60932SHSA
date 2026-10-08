<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Klient;
use App\Models\Kosmetolog;
use App\Models\Usluga;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@local.salon'],
            [
                'name' => 'Администратор',
                'telefon' => '+70000000001',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'klient_id' => null,
            ]
        );

        $klient = Klient::updateOrCreate(
            ['telefon' => '+70000000002'],
            ['fio' => 'Анна Смирнова']
        );

        User::updateOrCreate(
            ['email' => 'user@local.salon'],
            [
                'name' => 'Анна Смирнова',
                'telefon' => '+70000000002',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'klient_id' => $klient->id,
            ]
        );

        $cleaning = Usluga::firstOrCreate(
            ['nazvanie' => 'Чистка лица'],
            ['stoimost' => 2500, 'prodolzhitelnost' => 60, 'image' => null]
        );
        $massage = Usluga::firstOrCreate(
            ['nazvanie' => 'Массаж лица'],
            ['stoimost' => 3000, 'prodolzhitelnost' => 90, 'image' => null]
        );

        $master = Kosmetolog::firstOrCreate(
            ['fio' => 'Мария Петрова'],
            [
                'specialnost' => 'Косметолог-эстетист',
                'nachalo_raboty' => '09:00',
                'konec_raboty' => '18:00',
            ]
        );
        $master->uslugi()->syncWithoutDetaching([$cleaning->id, $massage->id]);
    }
}
