<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        DB::table('estados')->insert([
            'nom_estado' => "Sin Estado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Activo",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Inactivo",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Modificado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Eliminado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Cerrado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Anulado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Facturado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Contabilizado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Suspendido",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Reversado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Archivado",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->insert([
            'nom_estado' => "Borrado físico",
            'created_at' => Carbon::now()
        ]);

        DB::table('estados')->update(['estado_id' => 2]);
    }
}
