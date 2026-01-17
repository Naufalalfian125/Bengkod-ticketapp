<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dan kategori
        $userId = \App\Models\User::where('role', 'admin')->first()->id ?? 1;
        $kategori1 = \App\Models\Kategori::first()->id ?? 1;
        $kategori2 = \App\Models\Kategori::skip(1)->first()->id ?? $kategori1;
        $kategori3 = \App\Models\Kategori::skip(2)->first()->id ?? $kategori1;

        $events = [
            [
                'user_id' => $userId,
                'judul' => 'Konser Musik Rock',
                'deskripsi' => 'Nikmati malam penuh energi dengan band rock terkenal. Acara ini akan menghadirkan berbagai band rock terbaik dengan penampilan yang spektakuler.',
                'tanggal_waktu' => now()->addDays(30)->format('Y-m-d H:i:s'), // 30 hari dari sekarang
                'lokasi' => 'Stadion Utama Jakarta',
                'kategori_id' => $kategori1,
                'gambar' => null,
            ],
            [
                'user_id' => $userId,
                'judul' => 'Pameran Seni Kontemporer',
                'deskripsi' => 'Jelajahi karya seni modern dari seniman lokal dan internasional. Pameran ini menampilkan berbagai karya seni kontemporer yang menginspirasi.',
                'tanggal_waktu' => now()->addDays(45)->format('Y-m-d H:i:s'), // 45 hari dari sekarang
                'lokasi' => 'Galeri Seni Kota Bandung',
                'kategori_id' => $kategori2,
                'gambar' => null,
            ],
            [
                'user_id' => $userId,
                'judul' => 'Festival Makanan Internasional',
                'deskripsi' => 'Cicipi berbagai hidangan lezat dari seluruh dunia. Festival ini menghadirkan berbagai kuliner dari berbagai negara dengan cita rasa autentik.',
                'tanggal_waktu' => now()->addDays(60)->format('Y-m-d H:i:s'), // 60 hari dari sekarang
                'lokasi' => 'Taman Kota Surabaya',
                'kategori_id' => $kategori3,
                'gambar' => null,
            ],
            [
                'user_id' => $userId,
                'judul' => 'Workshop Teknologi Digital',
                'deskripsi' => 'Pelajari teknologi terbaru dalam workshop interaktif. Cocok untuk developer dan tech enthusiast yang ingin mengembangkan skill mereka.',
                'tanggal_waktu' => now()->addDays(15)->format('Y-m-d H:i:s'), // 15 hari dari sekarang
                'lokasi' => 'Convention Center Yogyakarta',
                'kategori_id' => $kategori1,
                'gambar' => null,
            ],
            [
                'user_id' => $userId,
                'judul' => 'Konser Jazz Night',
                'deskripsi' => 'Malam penuh harmoni dengan musik jazz yang menenangkan. Menampilkan musisi jazz terkenal dengan atmosfer yang intimate.',
                'tanggal_waktu' => now()->addDays(20)->format('Y-m-d H:i:s'), // 20 hari dari sekarang
                'lokasi' => 'Jazz Cafe Semarang',
                'kategori_id' => $kategori1,
                'gambar' => null,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}