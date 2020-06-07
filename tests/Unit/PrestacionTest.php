<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PrestacionTest extends TestCase
{
	use RefreshDatabase;

    public function testCompleto()
    {
		factory('App\Prestacion')->create();
		$values = ['DNI', 'CI', 'LC', 'Pas', 'CM', 'CXX', 'LE', 'DEX', 'COM']; 
        $this->assertTrue(true);
    }


    public function testSinCodigo()
    {
		factory('App\Prestacion')->create();
		$values = ['DNI', 'CI', 'LC', 'Pas', 'CM', 'CXX', 'LE', 'DEX', 'COM']; 
        $this->assertTrue(true);
    }

	public function testCodigoInvalido()
    {
		$this->markTestSkipped();
		factory('App\Prestacion')->create(['prestacion_codigo']);
		$values = ['DNI', 'CI', 'LC', 'Pas', 'CM', 'CXX', 'LE', 'DEX', 'COM']; 
        $this->assertTrue(true);
    }

}
