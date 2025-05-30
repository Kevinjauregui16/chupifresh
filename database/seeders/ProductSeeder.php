<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'Gansito',
            'Oreo',
            'Mazapán',
            'Kinder delice',
            'Danonino',
            'Coco',
            'Vainilla',
            'Nutella',
            'Príncipe',
            'Duvalin',
            'Nuez',
            'Pay de limón',
            'Ferrero',
            'Fresas con crema',
            'Mango',
            'Fresa',
            'Jamaica',
            'Tamarindo',
            'Picafresa',
            'Mango con chile',
        ];

        foreach ($products as $name) {
            Product::create([
                'name' => $name,
                'cost' => 10,
                'price' => 15,
                'quantity' => 20,
            ]);
        }
    }
}
