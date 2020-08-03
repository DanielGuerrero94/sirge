<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioSirge extends Model
{
	protected $connection = 'sirge';

	protected $table = 'sistema.usuarios';

	protected $primaryKey = 'id_usuario';
}
