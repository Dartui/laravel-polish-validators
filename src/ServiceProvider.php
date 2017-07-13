<?php

namespace Dartui\PolishValidators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		Validator::extend( 'valid', function ( $attribute, $value, $parameters ) {
			return ValidatorExtend::valid( $attribute, $value, $parameters );
		} );
	}
}
