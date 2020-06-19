<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaPampaPrestaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_pampa_prestaciones', function (Blueprint $table) {
            $table->id();
			$table->string('operacion')->nullable();
			$table->string('estado')->nullable();
			$table->string('num_liq')->nullable();
			$table->string('practica')->nullable();
			$table->string('subcat')->nullable();
			$table->string('Valor')->nullable();
			$table->string('Fecha_Consulta')->nullable();
			$table->string('clave_benef')->nullable();
			$table->string('tipo_doc')->nullable();
			$table->string('clase_doc')->nullable();
			$table->string('nro_doc')->nullable();
			$table->string('id1')->nullable();
			$table->string('dato_id1')->nullable();
			$table->string('id2')->nullable();
			$table->string('dato_id2')->nullable();
			$table->string('id3')->nullable();
			$table->string('dato_id3')->nullable();
			$table->string('id4')->nullable();
			$table->string('dato_id4')->nullable();
			$table->string('indice')->nullable();
			$table->string('cuie')->nullable();
			$table->string('id_prest')->nullable();
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
        Schema::dropIfExists('la_pampa_prestaciones');
    }
}
