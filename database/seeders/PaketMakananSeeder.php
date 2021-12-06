<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class PaketMakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('paket_makans')->insert([
            'namaPaket' => 'Paket Murah [1 Porsi Sei Sapi + Nasi + Es Teh]',
            'hargaPaket' => '37000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('paket_makans')->insert([
            'namaPaket' => 'Paket Kenyang [3 Porsi Sei Sapi + Nasi + 3 Es Teh]',
            'hargaPaket' => '95000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('paket_makans')->insert([
            'namaPaket' => 'Paket Keluarga [5 Porsi Sei Sapi + Nasi + 5 Es Teh]',
            'hargaPaket' => '160000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
