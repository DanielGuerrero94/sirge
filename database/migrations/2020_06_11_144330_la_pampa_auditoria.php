<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaPampaAuditoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_pampa_auditoria', function (Blueprint $table) {
            $table->id();
			$table->string('id_Prestacion')->nullable();
			$table->string('Codigo_Prestacion')->nullable();
			$table->string('Cuie_Efector')->nullable();
			$table->string('Fecha_Prestacion')->nullable();
			$table->string('Apellido_Beneficiario')->nullable();
			$table->string('Nombre_Beneficiario')->nullable();
			$table->string('clave_Beneficiario')->nullable();
			$table->string('BENEF_TIPO_DOCUMENTO')->nullable();
			$table->string('BENEF_CLASE_DOCUMENTO')->nullable();
			$table->string('BENEF_NUMERO_DOCUMENTO')->nullable();
			$table->string('SEXO')->nullable();
			$table->string('FECHA_DE_NACIMIENTO')->nullable();
			$table->string('VALOR_UNITARIO')->nullable();
			$table->string('CANTIDAD')->nullable();
			$table->string('NUM_FACTURA')->nullable();
			$table->string('FECHA_FACTURA')->nullable();
			$table->string('NUMERO_EXP')->nullable();
			$table->string('FECHA_ING_EXP')->nullable();
			$table->string('IMPORTE_FACTURADO')->nullable();
			$table->string('IMPORTE_LIQUIDADO')->nullable();
			$table->string('FECHA_LIQUIDACION')->nullable();
			$table->string('NUM_LIQUIDACION')->nullable();
			$table->string('FECHA_DEBITO_BANCARIO')->nullable();
			$table->string('FECHA_NOTIFICACION_PAGO')->nullable();
			$table->string('PRESTACION_NO_CATRASTOFICA')->nullable();
			$table->string('DR1')->nullable();
			$table->string('dato_DR1')->nullable();
			$table->string('DR2')->nullable();
			$table->string('dato_DR2')->nullable();
			$table->string('DR3')->nullable();
			$table->string('dato_DR3')->nullable();
			$table->string('DR4')->nullable();
			$table->string('dato_DR4')->nullable();
			$table->string('dom')->nullable();
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
