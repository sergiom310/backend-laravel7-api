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

        // * registros únicos de tablas *

        DB::table('tipo_accion')->insert([
            'des_tipo_accion' => "Sin acción",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('tipo_documento')->insert([
            'des_tipo_documento' => "Sin tipo documento",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('tipo_habitacion')->insert([
            'des_tipo_habitacion' => "Sin tipo habitación",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('tipo_identificacion')->insert([
            'tipo_identificacion' => "XX",
            'des_tipo_identificacion' => 'Sin detalle tipo identificación',
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('tipo_servicio')->insert([
            'des_tipo_servicio' => "Sin tipo servicio",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('clientes')->insert([
            'tipo_identificacion_id' => 1,
            'num_identificacion' => 0,
            'nom_cliente' => "Sin cliente",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('habitaciones')->insert([
            'tipo_habitacion_id' => 1,
            'nom_habitacion' => "Sin habitación",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('servicios')->insert([
            'tipo_servicio_id' => 1,
            'habitacion_id' => 1,
            'nom_servicio' => "Sin servicio",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('reservaciones')->insert([
            'cliente_id' => 1,
            'habitacion_id' => 1,
            'check_in' => Carbon::now(),
            'chech_out' => Carbon::now(),
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('turnos_trabajos')->insert([
            'nom_turno_trabajo' => "Sin turno de trabajo",
            'hora_desde' => "00:00",
            'hora_hasta' => "00:00",
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('documentos')->insert([
            'tipo_documento_id' => 1,
            'reservaciones_id' => 1,
            'turno_trabajo_id' => 1,
            'user_id_created_at' => 1,
            'user_id_updated_at' => 1,
            'impuestos' => 0,
            'valor_total' => 0,
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

        DB::table('movimientos')->insert([
            'documento_id' => 1,
            'servicio_id' => 1,
            'valor_servicio' => 0,
            'valor_total' => 0,
            'cantidad' => 0,
            'estado_id' => 1,
            'created_at' => Carbon::now()
        ]);

    }
}
