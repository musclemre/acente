<?php

namespace Database\Seeders;

use App\Models\Acente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Acente::create([
            'kod' => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
            'acente_adi' => 'TEST ACENTE',
            'acente_aciklama' => 'TEST ACENTE AÇIKLAMA',
            'sorumlu_adi' => 'TEST SORUMLU',
            'sorumlu_telefon' => '0555 555 55 55',
            'slug' => Str::slug('TEST ACENTE'),
            'durum' => 1,
        ]);
    }
}
