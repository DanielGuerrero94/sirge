<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
	protected $connection = 'sirge';

	protected $table = 'geo.provincias';

	protected $guarded = [];
    //
}
