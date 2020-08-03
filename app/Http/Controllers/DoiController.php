<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;
use App\UsuarioSirge;
use Log;

class DoiController extends Controller
{
	public function index(Request $request)
	{
		$token = $request->header('X-Authorization');

		Log::info($token);

		$data = ['token' => $token];
		$data['upload_file_permission'] = false;

		if ($this->isUec($token)) {
			$data['provincias'] = Provincia::get();
		}
		
		if ($this->haveUploadPermission($token)) {
			$data['upload_file_permission'] = true;
		}
		
		return view('doi3.doi3', $data);
	}

	public function isUec($token)
	{
		config(['database.connections.sirge.port' => '5432']);
		$usuario = UsuarioSirge::where('token', $token)->first();
		Log::info(json_encode($usuario));
		return in_array($usuario->id_menu, [1, 2, 11, 16]);
	}

	public function haveUploadPermission($token)
	{
		config(['database.connections.sirge.port' => '5432']);
		$usuario = UsuarioSirge::where('token', $token)->first();
		return in_array($usuario->id_menu, [1, 2, 3]);
	}

}
