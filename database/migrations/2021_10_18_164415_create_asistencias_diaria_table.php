<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasDiariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias_diaria', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('clave');
            $table->foreign('clave')->references('clave')->on('empleados');
            $table->char("dia");
            $table->time("entrada");
            $table->time("salida");
            $table->string("status");
            $table->date("fecha");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencias_diaria');
    }
}
