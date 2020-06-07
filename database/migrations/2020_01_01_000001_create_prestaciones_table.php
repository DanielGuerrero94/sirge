<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		$statements[] = <<<HEREDOC
CREATE TABLE prestaciones (
    id serial,
    id_provincia character(2),
    id_prestacion integer,
    prestacion_codigo character varying(11),
    cuie character(6),
    prestacion_fecha date,
    beneficiario_apellido character varying(100),
    beneficiario_nombre character varying(100),
    beneficiario_clave character varying(16),
    beneficiario_tipo_documento character(3),
    beneficiario_clase_documento character(1),
    beneficiario_nro_documento character varying(14),
    beneficiario_sexo character(1),
    beneficiario_nacimiento date,
    valor_unitario_facturado numeric(7,2),
    cantidad_facturado integer,
    importe_prestacion_facturado numeric(9,2),
    id_factura integer,
    factura_nro character varying(100),
    factura_fecha date,
    factura_importe_total numeric(9,2),
    factura_fecha_recepcion date,
    alta_complejidad character(1),
    id_liquidacion integer,
    liquidacion_fecha date,
    valor_unitario_aprobado numeric(7,2),
    cantidad_aprobada integer,
    importe_prestacion_aprobado numeric(9,2),
	numero_comprobante_extracto_bancario character varying(100),
    id_dato_reportable_1 integer,
    dato_reportable_1 character varying(255),
    id_dato_reportable_2 integer,
    dato_reportable_2 character varying(255),
    id_dato_reportable_3 integer,
    dato_reportable_3 character varying(255),
    id_dato_reportable_4 integer,
    dato_reportable_4 character varying(255),
    id_dato_reportable_5 integer,
    dato_reportable_5 character varying(255),
    id_op integer,
    numero_op character varying(100),
    fecha_op date,
    importe_total_op numeric(7,2),
    numero_expte character varying(100),
    fecha_debito_bancario date,
    importe_debito_bancario numeric(9,2),
    fecha_notificacion_efector date,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);
HEREDOC;

		foreach($statements as $statement) {
			DB::statement($statement);
		}
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestaciones');
    }
}
