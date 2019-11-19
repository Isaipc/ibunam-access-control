<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rfc', 15)->unique();
            $table->string('nombre', 50);
            $table->string('apellidos', 200);
            $table->string('telefono', 12)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->integer('horario_id')->unsigned()->nullable();
            $table->integer('categoria_id')->unsigned();
            $table->foreign('horario_id')->references('id')->on('horarios_empleado');
            $table->foreign('categoria_id')->references('id')->on('categorias');
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
        Schema::dropIfExists('empleados');
    }
}
