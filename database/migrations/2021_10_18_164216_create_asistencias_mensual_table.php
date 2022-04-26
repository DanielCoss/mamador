<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasMensualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias_mensual', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('clave');
            $table->foreign('clave')->references('clave')->on('empleados');
            $table->string("mes");
            $table->string("anno");
            $table->integer("retardos");
            $table->integer("faltas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencias_mensual');
    }
}
