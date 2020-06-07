<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\ImportacionController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ImportacionTest extends TestCase
{
	use RefreshDatabase;

	public function __construct()
	{
	    $this->setUp(); // **THIS IS THE PROBLEM LINE**
	}

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
		$request = new Request();
		$output = app(ImportacionController::class)->store($request);
        $this->assertNotNull($output);
    }
}
