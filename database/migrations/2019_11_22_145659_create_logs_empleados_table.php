<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('entrada')->nullable(false);
            $table->dateTime('salida')->nullable(false);
            $table->bigInteger('empleado_id')->unsigned()->index();
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
        Schema::dropIfExists('logs_empleados');
    }
}
