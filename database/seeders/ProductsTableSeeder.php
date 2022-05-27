<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Types\Boolean;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<11;$i++)
        \Illuminate\Support\Facades\DB::table('products')->insert([
            'name' => 'Product '.$i,
            'price' => rand(10,1000),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequa',
            'available' => true,
            'sostav' => 'Lorem ipsum dolor sit amet',
            'mass' => rand(10,1000),
        ]);
    }
}
