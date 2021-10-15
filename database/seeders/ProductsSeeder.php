<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Banano Criollo',
            'price' => '800'
        ]);

        DB::table('products')->insert([
            'name' => 'Leche deslactosada',
            'price' => '2600'
        ]);

        DB::table('products')->insert([
            'name' => 'Huevos AA',
            'price' => '1300'
        ]);

        DB::table('products')->insert([
            'name' => 'Limpiapisos',
            'price' => '2300'
        ]);

        DB::table('products')->insert([
            'name' => 'Papaya',
            'price' => '950'
        ]);
    }
}
