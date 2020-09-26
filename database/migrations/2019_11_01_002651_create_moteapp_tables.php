<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoteappTables extends Migration
{
    /**
     * Run the migrations.
     * https://laravel.com/docs/6.x/migrations#creating-columns
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('nom_estado', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('tipo_servicio', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('des_tipo_servicio', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('tipo_habitacion', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('des_tipo_habitacion', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('des_tipo_documento', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('tipo_identificacion', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('tipo_identificacion', 5);
            $table->string('des_tipo_identificacion', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('tipo_identificacion_id');
            $table->foreign('tipo_identificacion_id')->references('id')->on('tipo_identificacion');
            $table->string('num_identificacion', 20);
            $table->string('nom_cliente', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('habitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('estatus');
            $table->foreign('estatus')->references('id')->on('estados');
            $table->unsignedSmallInteger('tipo_habitacion_id');
            $table->foreign('tipo_habitacion_id')->references('id')->on('tipo_habitacion');
            $table->string('nom_habitacion', 50);
            $table->timestamps();
        });

        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('tipo_servicio_id');
            $table->foreign('tipo_servicio_id')->references('id')->on('tipo_servicio');
            $table->unsignedInteger('habitacion_id');
            $table->foreign('habitacion_id')->references('id')->on('habitaciones');
            $table->string('nom_servicio', 50);
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->unsignedInteger('habitacion_id');
            $table->foreign('habitacion_id')->references('id')->on('habitaciones');
            $table->unsignedSmallInteger('estatus');
            $table->foreign('estatus')->references('id')->on('estados');
            $table->datetime('check_in')->nullable();
            $table->datetime('chech_out')->nullable();
            $table->timestamps();
        });

        Schema::create('turnos_trabajos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('estatus');
            $table->foreign('estatus')->references('id')->on('estados');
            $table->string('nom_turno_trabajo', 50);
            $table->string('hora_desde', 5);
            $table->string('hora_hasta', 5);
            $table->timestamps();
        });

        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('tipo_documento_id');
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento');
            $table->unsignedInteger('reservaciones_id');
            $table->foreign('reservaciones_id')->references('id')->on('reservaciones');
            $table->decimal('impuestos', 11, 2)->default(0.00);
            $table->decimal('valor_total', 11, 2)->default(0.00);
            $table->unsignedInteger('turno_trabajo_id');
            $table->foreign('turno_trabajo_id')->references('id')->on('turnos_trabajos');
            $table->unsignedBigInteger('user_id_created_at')->nullable();
            $table->foreign('user_id_created_at')->references('id')->on('users');
            $table->unsignedBigInteger('user_id_updated_at')->nullable();
            $table->foreign('user_id_updated_at')->references('id')->on('users');
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_id')->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->unsignedInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->decimal('valor_servicio', 11, 2)->default(0.00);
            $table->decimal('valor_total', 11, 2)->default(0.00);        
            $table->unsignedSmallInteger('cantidad');
            $table->unsignedSmallInteger('estatus')->nullable()->default(2);
            $table->foreign('estatus')->references('id')->on('estados');
            $table->timestamps();
        });

        Schema::create('bitacora', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('estatus');
            $table->foreign('estatus')->references('id')->on('estados');
            $table->integer('tabla_id');
            $table->unsignedSmallInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nom_tabla', 50);
            $table->longtext('obs_bitacora');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_servicio');
        Schema::dropIfExists('estados');
        Schema::dropIfExists('tipo_habitacion');
        Schema::dropIfExists('tipo_documento');
        Schema::dropIfExists('tipo_identificacion');
        Schema::dropIfExists('tipo_accion');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('habitaciones');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('reservaciones');
        Schema::dropIfExists('turnos_trabajos');
        Schema::dropIfExists('documentos');
        Schema::dropIfExists('movimientos');
        Schema::dropIfExists('bitacora');
    }
}
