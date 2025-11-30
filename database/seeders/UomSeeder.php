<?php

namespace Database\Seeders;

use App\Models\Uom;
use Illuminate\Database\Seeder;

class UomSeeder extends Seeder
{
   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $uoms = [
            ['name' => 'Meter','abbreviation' => 'm'],
            ['name' => 'Colt','abbreviation' => 'colt'],
            ['name' => 'Kubik','abbreviation' => 'm3'],
            ['name' => 'Sak','abbreviation' => 'sak'],
            ['name' => 'Lembar','abbreviation' => 'lbr'],
            ['name' => 'Ikat','abbreviation' => 'ikat'],
            ['name' => 'Kg','abbreviation' => 'kg'],
            ['name' => 'Buah','abbreviation' => 'bh'],
            ['name' => 'Batang','abbreviation' => 'btg'],
            ['name' => 'Set','abbreviation' => 'set'],
            ['name' => 'Dus','abbreviation' => 'dus'],
            ['name' => 'Pcs','abbreviation' => 'pcs'],
            ['name' => 'Pail','abbreviation' => 'pail'],
            ['name' => 'Kaleng','abbreviation' => 'klg'],
            ['name' => 'Lumpsum','abbreviation' => 'ls'],
        ];

        foreach ($uoms as $uom) {
            Uom::create($uom);
        }

    }
}
