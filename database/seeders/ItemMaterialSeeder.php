<?php

namespace Database\Seeders;

use App\Models\ItemMaterial;
use App\Models\Uom;
use Illuminate\Database\Seeder;

class ItemMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'name' => 'Pasir',
                'description' => 'Pasir',
                'quantity' => 4,
                'uom' => 'colt',
            ],
            [
                'name' => 'Hebel',
                'description' => 'Hebel',
                'quantity' => 11,
                'uom' => 'm3',
            ],
            [
                'name' => 'Lem Hebel',
                'description' => 'Lem Hebel',
                'quantity' => 10,
                'uom' => 'sak',
            ],
            [
                'name' => 'Semen',
                'description' => 'Semen',
                'quantity' => 32,
                'uom' => 'sak',
            ],
            [
                'name' => 'Semen Acian',
                'description' => 'Semen Acian',
                'quantity' => 12,
                'uom' => 'sak',
            ],
            [
                'name' => 'Triplek 8 mm',
                'description' => 'Triplek 8 mm',
                'quantity' => 4,
                'uom' => 'lbr',
            ],
            [
                'name' => 'Split',
                'description' => 'Split',
                'quantity' => 1,
                'uom' => 'colt',
            ],
            [
                'name' => 'Ring 8x12',
                'description' => 'Ring 8x12',
                'quantity' => 4,
                'uom' => 'ikat',
            ],
            [
                'name' => 'Kawat Bendrat',
                'description' => 'Kawat Bendrat',
                'quantity' => 4,
                'uom' => 'kg',
            ],
            [
                'name' => 'Benang',
                'description' => 'Benang',
                'quantity' => 4,
                'uom' => 'bh',
            ],
            [
                'name' => 'Ceker Ayam',
                'description' => 'Ceker Ayam',
                'quantity' => 4,
                'uom' => 'bh',
            ],
            [
                'name' => 'Papan Cor',
                'description' => 'Papan Cor',
                'quantity' => 10,
                'uom' => 'lbr',
            ],
            [
                'name' => 'Besi Beton 8 Full Polos',
                'description' => 'Besi Beton 8 Full Polos',
                'quantity' => 20,
                'uom' => 'btg',
            ],
            [
                'name' => 'Besi Beton 6 Full Polos',
                'description' => 'Besi Beton 6 Full Polos',
                'quantity' => 17,
                'uom' => 'bh',
            ],
            [
                'name' => 'Besi Holo 4x4',
                'description' => 'Besi Holo 4x4',
                'quantity' => 44,
                'uom' => 'btg',
            ],
            [
                'name' => 'Besi Holo 2x4',
                'description' => 'Besi Holo 2x4',
                'quantity' => 16,
                'uom' => 'btg',
            ],
            [
                'name' => 'Baja Ringan CNP 0,75 STD',
                'description' => 'Baja Ringan CNP 0,75 STD',
                'quantity' => 50,
                'uom' => 'lbr',
            ],
            [
                'name' => 'Reng Baja Ringan 0,35',
                'description' => 'Reng Baja Ringan 0,35',
                'quantity' => 35,
                'uom' => 'btg',
            ],
            [
                'name' => 'Genteng Metal Biru',
                'description' => 'Genteng Metal Biru',
                'quantity' => 84,
                'uom' => 'lbr',
            ],
            [
                'name' => 'Nok Genteng Metal',
                'description' => 'Nok Genteng Metal',
                'quantity' => 8,
                'uom' => 'lbr',
            ],
            [
                'name' => 'Paku 10 cm',
                'description' => 'Paku 10 cm',
                'quantity' => 2,
                'uom' => 'kg',
            ],
            [
                'name' => 'Paku 7 cm',
                'description' => 'Paku 7 cm',
                'quantity' => 2,
                'uom' => 'kg',
            ],
            [
                'name' => 'Paku 5 cm',
                'description' => 'Paku 5 cm',
                'quantity' => 1,
                'uom' => 'kg',
            ],
            [
                'name' => 'Paku 4 cm',
                'description' => 'Paku 4 cm',
                'quantity' => 1,
                'uom' => 'kg',
            ],
            [
                'name' => 'Ember Kecil',
                'description' => 'Ember Kecil',
                'quantity' => 4,
                'uom' => 'bh',
            ],
            [
                'name' => 'Hendel Pintu',
                'description' => 'Hendel Pintu',
                'quantity' => 3,
                'uom' => 'bh',
            ],
            [
                'name' => 'Engsel 5"',
                'description' => 'Engsel 5"',
                'quantity' => 3,
                'uom' => 'set',
            ],
            [
                'name' => 'Engsel 3"',
                'description' => 'Engsel 3"',
                'quantity' => 3,
                'uom' => 'set',
            ],
            [
                'name' => 'Slot Jendela',
                'description' => 'Slot Jendela',
                'quantity' => 3,
                'uom' => 'bh',
            ],
            [
                'name' => 'Kusen Pintu 3 dan Jendela 3',
                'description' => 'Kusen Pintu 3 dan Jendela 3',
                'quantity' => 1,
                'uom' => 'set',
            ],
            [
                'name' => 'Kloset Jongkok',
                'description' => 'Kloset Jongkok',
                'quantity' => 1,
                'uom' => 'bh',
            ],
            [
                'name' => 'Pintu WC (PVC)',
                'description' => 'Pintu WC (PVC)',
                'quantity' => 1,
                'uom' => 'bh',
            ],
            [
                'name' => 'Keramik Putih Polos 40x40',
                'description' => 'Keramik Putih Polos 40x40',
                'quantity' => 38,
                'uom' => 'dus',
            ],
            [
                'name' => 'Keramik Lantai Kamar Mandi',
                'description' => 'Keramik Lantai Kamar Mandi',
                'quantity' => 3,
                'uom' => 'dus',
            ],
            [
                'name' => 'Pipa Paralon 3"',
                'description' => 'Pipa Paralon 3"',
                'quantity' => 2,
                'uom' => 'bh',
            ],
            [
                'name' => 'Keni L 3"',
                'description' => 'Keni L 3"',
                'quantity' => 2,
                'uom' => 'bh',
            ],
            [
                'name' => 'Keran Air',
                'description' => 'Keran Air',
                'quantity' => 1,
                'uom' => 'bh',
            ],
            [
                'name' => 'Pipa Paralon 1/2"',
                'description' => 'Pipa Paralon 1/2"',
                'quantity' => 3,
                'uom' => 'bh',
            ],
            [
                'name' => 'Keni 1/2"',
                'description' => 'Keni 1/2"',
                'quantity' => 3,
                'uom' => 'bh',
            ],
            [
                'name' => 'Lem Pipa',
                'description' => 'Lem Pipa',
                'quantity' => 1,
                'uom' => 'bh',
            ],
            [
                'name' => 'Sealtip',
                'description' => 'Sealtip',
                'quantity' => 1,
                'uom' => 'pcs',
            ],
            [
                'name' => 'Floor drain',
                'description' => 'Floor drain',
                'quantity' => 1,
                'uom' => 'pcs',
            ],
            [
                'name' => 'Cat Tembok',
                'description' => 'Cat Tembok',
                'quantity' => 1,
                'uom' => 'pail',
            ],
            [
                'name' => 'Lem Fox',
                'description' => 'Lem Fox',
                'quantity' => 1,
                'uom' => 'kg',
            ],
            [
                'name' => 'Cat Kayu',
                'description' => 'Cat Kayu',
                'quantity' => 2,
                'uom' => 'klg',
            ],
            [
                'name' => 'Skrup Gypsum',
                'description' => 'Skrup Gypsum',
                'quantity' => 4,
                'uom' => 'dus',
            ],
            [
                'name' => 'Gypsum',
                'description' => 'Gypsum',
                'quantity' => 14,
                'uom' => 'lbr',
            ],
            [
                'name' => 'Kompon',
                'description' => 'Kompon',
                'quantity' => 1,
                'uom' => 'sak',
            ],
            [
                'name' => 'Kasa Lem',
                'description' => 'Kasa Lem',
                'quantity' => 3,
                'uom' => 'pcs',
            ],
            [
                'name' => 'Baut Baja Ringan',
                'description' => 'Baut Baja Ringan',
                'quantity' => 2,
                'uom' => 'dus',
            ],
            [
                'name' => 'Lispang 20x240 polos',
                'description' => 'Lispang 20x240 polos',
                'quantity' => 3,
                'uom' => 'pcs',
            ],
            [
                'name' => 'Kaso 4x6',
                'description' => 'Kaso 4x6',
                'quantity' => 2,
                'uom' => 'ikat',
            ],
            [
                'name' => 'Skrup Baja Ringan',
                'description' => 'Skrup Baja Ringan',
                'quantity' => 2,
                'uom' => 'dus',
            ],
            [
                'name' => 'Dinabol',
                'description' => 'Dinabol',
                'quantity' => 5,
                'uom' => 'dus',
            ],
            [
                'name' => 'WD Potong',
                'description' => 'WD Potong',
                'quantity' => 3,
                'uom' => 'pcs',
            ],
            [
                'name' => 'Tiner',
                'description' => 'Tiner',
                'quantity' => 1,
                'uom' => 'klg',
            ],
            [
                'name' => 'Roll Cat',
                'description' => 'Roll Cat',
                'quantity' => 2,
                'uom' => 'bh',
            ],
            [
                'name' => 'Kuas',
                'description' => 'Kuas',
                'quantity' => 2,
                'uom' => 'bh',
            ],
            [
                'name' => 'Instalasi Listrik',
                'description' => 'Instalasi Listrik',
                'quantity' => 1,
                'uom' => 'ls',
            ],
        ];

        foreach ($materials as $material) {
            $uom = Uom::where('abbreviation', $material['uom'])->first();

            ItemMaterial::create([
                'name' => $material['name'],
                'description' => $material['description'],
                'quantity' => $material['quantity'],
                'uom_id' => $uom->id,
            ]);
        }
    }
}
