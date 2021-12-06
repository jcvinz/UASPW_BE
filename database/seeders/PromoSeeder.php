<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('promos')->insert([
            'namaPromo' => 'NATAL20',
            'totalDiskon' => 0.2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
