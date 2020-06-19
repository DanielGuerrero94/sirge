<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ValidarPrestaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION validar_prestaciones() RETURNS trigger AS $validar_prestaciones$
	DECLARE
	  text_var1 text;
	  text_var2 text;
	  text_var3 text;
	  text_var4 text;
    BEGIN
        IF NEW.id_prestacion IS NULL THEN
            RAISE NOTICE 'Tiene que indicar un id de prestacion';
        END IF;
        IF NEW.id_provincia IS NULL THEN
            RAISE NOTICE 'Tiene que indicar un id de provincia';
        END IF;

        IF NEW.id_provincia NOT SIMILAR TO '01' THEN
            RAISE NOTICE '% no es un id de provincia valido', NEW.id_provincia;
        END IF;
		
		--if NEW.prestacion_codigo NOT SIMILAR TO 'B2' THEN
            --RAISE EXCEPTION '% no es un codigo de prestacion valido', NEW.prestacion_codigo;
        --END IF;

        -- Remember who changed the payroll when
        --NEW.last_date := current_timestamp;
        --NEW.last_user := current_user;

        RETURN NEW;
    END;
$validar_prestaciones$ LANGUAGE plpgsql;
HEREDOC;

		$statements[] = <<<HEREDOC
CREATE TRIGGER validar_prestaciones_trigger BEFORE INSERT OR UPDATE ON prestaciones
    FOR EACH ROW EXECUTE PROCEDURE validar_prestaciones();
HEREDOC;

		$statements[] = <<<'HEREDOC'
DROP FUNCTION check_tipo_documento;
HEREDOC;

		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION check_tipo_documento(check_id_importacion integer, check_id_provincia character(2)) RETURNS table(id_importacion integer, id_provincia character(2), id_prestacion bigint, beneficiario_tipo_documento character(3)) AS $check_tipo_documento$
    BEGIN
		RETURN QUERY SELECT prestaciones.id_importacion, prestaciones.id_provincia, prestaciones.id_prestacion, prestaciones.beneficiario_tipo_documento from prestaciones where prestaciones.id_importacion = check_id_importacion and prestaciones.id_provincia = check_id_provincia and prestaciones.beneficiario_tipo_documento !~ 'DNI|PAS|DEX|COM|L(C|E)|C(I|M|0[1-9]|1[0-9]|2[0-4])';
    END;
$check_tipo_documento$ LANGUAGE plpgsql;
HEREDOC;

		$statements[] = <<<'HEREDOC'
DROP FUNCTION check_nombre;
HEREDOC;

		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION check_nombre(check_id_importacion integer, check_id_provincia character(2)) RETURNS table(id_importacion integer, id_provincia character(2), id_prestacion bigint, beneficiario_nombre character(100)) AS $check_nombre$
    BEGIN
		RETURN QUERY SELECT prestaciones.id_importacion, prestaciones.id_provincia, prestaciones.id_prestacion, prestaciones.beneficiario_nombre::character(100) from prestaciones where prestaciones.beneficiario_nombre is null;
    END;
$check_nombre$ LANGUAGE plpgsql;
HEREDOC;

		$statements[] = <<<'HEREDOC'
DROP FUNCTION check_apellido;
HEREDOC;

		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION check_apellido(check_id_importacion integer, check_id_provincia character(2)) RETURNS table(id_importacion integer, id_provincia character(2), id_prestacion bigint, beneficiario_apellido character(100)) AS $check_apellido$
    BEGIN
		RETURN QUERY SELECT prestaciones.id_importacion, prestaciones.id_provincia, prestaciones.id_prestacion, prestaciones.beneficiario_apellido::character(100) from prestaciones where prestaciones.beneficiario_apellido is null;
    END;
$check_apellido$ LANGUAGE plpgsql;
HEREDOC;

		$statements[] = <<<'HEREDOC'
DROP FUNCTION check_fecha_nacimiento;
HEREDOC;

		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION check_fecha_nacimiento(check_id_importacion integer, check_id_provincia character(2)) RETURNS table(id_importacion integer, id_provincia character(2), id_prestacion bigint, beneficiario_nacimiento date) AS $check_fecha_nacimiento$
    BEGIN
		RETURN QUERY SELECT prestaciones.id_importacion, prestaciones.id_provincia, prestaciones.id_prestacion, prestaciones.beneficiario_nacimiento::date from prestaciones where prestaciones.beneficiario_nacimiento is null;
    END;
$check_fecha_nacimiento$ LANGUAGE plpgsql;
HEREDOC;

		$statements[] = <<<'HEREDOC'
DROP FUNCTION check_sexo;
HEREDOC;
		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION check_sexo(check_id_importacion integer, check_id_provincia character(2)) RETURNS table(id_importacion integer, id_provincia character(2), id_prestacion bigint, beneficiario_sexo character(1)) AS $check_sexo$
    BEGIN
		RETURN QUERY SELECT prestaciones.id_importacion, prestaciones.id_provincia, prestaciones.id_prestacion, prestaciones.beneficiario_sexo from prestaciones where prestaciones.beneficiario_sexo !~ 'M|F';
    END;
$check_sexo$ LANGUAGE plpgsql;
HEREDOC;

		$statements[] = <<<'HEREDOC'
DROP FUNCTION check_clase_documento;
HEREDOC;

		$statements[] = <<<'HEREDOC'
CREATE OR REPLACE FUNCTION check_clase_documento(check_id_importacion integer, check_id_provincia character(2)) RETURNS table(id_importacion integer, id_provincia character(2), id_prestacion bigint, beneficiario_clase_documento character(1)) AS $check_clase_documento$
    BEGIN
		RETURN QUERY SELECT prestaciones.id_importacion, prestaciones.id_provincia, prestaciones.id_prestacion, prestaciones.beneficiario_clase_documento from prestaciones where prestaciones.beneficiario_clase_documento !~ 'A|P|C';
    END;
$check_clase_documento$ LANGUAGE plpgsql;
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
		DB::statement('DROP TRIGGER validar_prestaciones_trigger on prestaciones');
		DB::statement('DROP FUNCTION validar_prestaciones');
    }
}
