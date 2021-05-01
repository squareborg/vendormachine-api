<?php

use Illuminate\Database\Seeder;
use App\Models\Products\ProductAttribute;

class ProductAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = ['color','size',];
        foreach($attributes as $attribute) {
            ProductAttribute::create([
                'name' => $attribute,
            ]);
        }

    }
}
