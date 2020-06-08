<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiccionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		$statements[] = <<<HEREDOC
CREATE TABLE diccionarios (
	id serial,
    tabla character varying(100) NOT NULL,
    orden integer NOT NULL,
    campo character varying(100),
    tipo character varying(100),
    obligatorio character(2),
    descripcion text,
    ejemplo text,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
	UNIQUE (tabla, orden)
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
        Schema::dropIfExists('diccionarios');
    }
}
