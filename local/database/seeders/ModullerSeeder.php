<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModullerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('moduller')->insert([
            [
                'id' => 1,
                'durum' => 1,
                'baslik' => 'Kullanıcılar',
                'prefix' => 'kullanici',
                'y1' => 'Görüntüle',
                'y2' => 'Ekle',
                'y3' => 'Düzenle',
                'y4' => 'Sil',
                'y5' => null,
                'y6' => null,
                'y7' => null,
                'y8' => null,
                'y9' => null,
                'y10' => null
            ],
            [
                'id' => 2,
                'durum' => 1,
                'baslik' => 'Müşteriler',
                'prefix' => 'musteri',
                'y1' => 'Görüntüle',
                'y2' => 'Ekle',
                'y3' => 'Düzenle',
                'y4' => 'Sil',
                'y5' => null,
                'y6' => null,
                'y7' => null,
                'y8' => null,
                'y9' => null,
                'y10' => null
            ],
        ]);
    }
}
