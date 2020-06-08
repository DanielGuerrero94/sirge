<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diccionario extends Model
{
	protected $guarded = [];

	/**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
	/*
    public function getEjemploAttribute($value)
    {
		$value = str_split($value, 15);
        return implode('\n', $value);
    }
	*/
}
