<?php namespace App\Providers;

use App\User;
use App\DrupalUserProvider;
use Illuminate\Support\ServiceProvider;

class DrupalServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app->auth->extend('drupal', function($app){
			// Return implementation of Illuminate\Contracts\Auth\UserProvider
			return new DrupalUserProvider(new User);
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
