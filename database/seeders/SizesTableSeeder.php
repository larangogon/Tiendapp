<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = ['S', 'M', 'L'];
        foreach ($sizes as $size) {
            \App\Models\Size::factory(Size::class)->create([
                'name' => $size
            ]);
        }
    }
}
