<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImportacionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
		$request = request(['id_provincia' => '01', 'filename' => 'test.csv']);
		$this->assertNotNull($request);

        $response = $this->post('/importaciones', $request);

        $response->assertStatus(200);
    }
}
