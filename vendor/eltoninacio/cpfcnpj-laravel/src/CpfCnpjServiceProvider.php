<?php 

namespace EltonInacio\ValidadorCpjCnpj;

use Illuminate\Support\ServiceProvider;
use EltonInacio\ValidadorCpjCnpj\Validation\CpfCnpjValidation;

class CpfCnpjServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app->validator->resolver(function($translator, $data, $rules, $messages)
		{
		    return new CpfCnpjValidation($translator, $data, $rules, $messages);
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
