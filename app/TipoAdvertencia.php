<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoAdvertencia extends Model
{
	use SoftDeletes;
	
	protected $guarded = [];
    //
}
