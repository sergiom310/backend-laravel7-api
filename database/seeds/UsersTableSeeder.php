<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "John Alexander Duarte Moreno",
            'username' => 'diseñador',
            'email' => "johnduartemoreno@gmail.com",
            'email_verified_at' => Carbon::now(),
            'activation_code' => Str::random(30).time(),
            'password' => bcrypt('12345678'),
            'tipo_documento' => 'Cédula',
            'documento' => '0000000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => "Cristhian Giovanny Otero Guayaban",
            'username' => 'desarrollador1',
            'email' => "crigiot@gmail.com",
            'email_verified_at' => Carbon::now(),
            'activation_code' => Str::random(30).time(),
            'password' => bcrypt('12345678'),
            'tipo_documento' => 'Cédula',
            'documento' => '1000000000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => "Sergio Giovanny Melo Chacón",
            'username' => 'desarrollador2',
            'email' => "sergiogiovanny05@gmail.com",
            'email_verified_at' => Carbon::now(),
            'activation_code' => Str::random(30).time(),
            'password' => bcrypt('12345678'),
            'tipo_documento' => 'Cédula',
            'documento' => '13746931',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
