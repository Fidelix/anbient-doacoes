<?php namespace App;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class DrupalUserProvider implements UserProvider {
	protected $model;

	public function __construct(Authenticatable $model)
	{
		$this->model = $model;
	}
	public function retrieveById($identifier){


	}
	public function retrieveByToken($identifier, $token)
	{

	}
	public function updateRememberToken(Authenticatable $user, $token)
	{

	}
	public function retrieveByCredentials(array $credentials)
	{

	}
	public function validateCredentials(Authenticatable $user, array $credentials)
	{

	}
}
