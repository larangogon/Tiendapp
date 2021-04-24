<?php

namespace Database\Seeders;

use App\Models\Trademark;
use Illuminate\Database\Seeder;

class TrademarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trademarks = ['polillo', 'Adidias', 'Toti'];
        foreach ($trademarks as $trademark) {
            \App\Models\Trademark::factory(Trademark::class)->create([
                'name' => $trademark,
                'code' => '123454'
            ]);
        }
    }
}
