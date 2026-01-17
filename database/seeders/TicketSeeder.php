<?php

namespace Database\Seeders;

use App\Models\Tiket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua event yang sudah dibuat
        $events = \App\Models\Event::all();

        foreach ($events as $event) {
            // Setiap event minimal punya 2 tiket (reguler dan premium)
            Tiket::create([
                'event_id' => $event->id,
                'tipe' => 'reguler',
                'harga' => rand(100000, 500000), // Harga random antara 100k - 500k
                'stok' => rand(100, 500),
            ]);

            Tiket::create([
                'event_id' => $event->id,
                'tipe' => 'premium',
                'harga' => rand(500000, 2000000), // Harga random antara 500k - 2jt
                'stok' => rand(50, 200),
            ]);
        }
    }
}