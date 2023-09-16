<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'type' => 'tyre',
            'sku' => '789-852',
            'name' => 'Dunlop Sport Maxx RT 2',
            'description' => 'Another Tyre',
            'cost' => 44.25,
        ]);
    }
}
