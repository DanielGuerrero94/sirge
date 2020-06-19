<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorImportacion extends Model
{
	use SoftDeletes;
	
	protected $guarded = [];
    //
}
