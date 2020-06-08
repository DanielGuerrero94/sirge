<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestacion extends Model
{
	protected $table = 'prestaciones';
	protected $guarded = [];


	public function scopeLiquidada($query)
    {
        return $query->whereNotNull('id_liquidacion');
    }
}
