<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaToLogsEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs_empleados', function (Blueprint $table) {
            $table->date('fecha');
            $table->time('entrada')->change();
            $table->time('salida')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs_empleados', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
}
