<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_empleado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empleado_id')->unsigned();
            $table->time('entrada')->nullable(false);
            $table->time('salida')->nullable(false);
            $table->integer('dia')->nullable(false);
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('horarios_empleado');
    }
}
