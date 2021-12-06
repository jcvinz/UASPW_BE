<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Jonathan Calvin',
            'no_telp' => '082215709630',
            'alamat' => 'Warnasari Cirebon',
            'email' => 'jonathancalvin123@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2a$12$73YR.36exdMLeCguf9Pbbu4rHGPAcog/2icwsXJjNZQmgx0ECyaTe', //calvin
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Jonathan Calvin',
            'no_telp' => '082215709630',
            'alamat' => 'Warnasari Cirebon',
            'email' => 'jonathancalvin21036@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2a$12$73YR.36exdMLeCguf9Pbbu4rHGPAcog/2icwsXJjNZQmgx0ECyaTe', //calvin
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}
