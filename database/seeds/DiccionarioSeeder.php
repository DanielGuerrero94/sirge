<?php

use Illuminate\Database\Seeder;
use App\Diccionario;

class DiccionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$query = <<<HEREDOC
SELECT (ordinal_position - 2) as ordinal_position, column_name, CASE 
WHEN character_maximum_length is not null THEN CONCAT(data_type, '(', character_maximum_length, ')') 
WHEN data_type = 'numeric' and numeric_precision is not null and numeric_scale is not null THEN CONCAT(data_type, '(', numeric_precision, ',', numeric_scale, ')') 
ELSE data_type 
END from information_schema.columns 
where table_name = 'prestaciones' and ordinal_position != 1 and ordinal_position != 2
and column_name != 'created_at' and column_name != 'updated_at'
order by ordinal_position;
HEREDOC;
	
		$result = DB::select($query);

		foreach($result as $row) {
			$data = [
				'tabla' => 'prestaciones',
				'orden' => $row->ordinal_position,
				'campo' => $row->column_name,
				'tipo' => $row->data_type
			];
			Diccionario::create($data);
		}

    }

}
