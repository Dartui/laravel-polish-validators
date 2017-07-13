<?php

namespace Dartui\PolishValidators;

class ValidatorExtend {
	public static function valid( $attribute, $value, $parameters ) {
		$self = new static;

		$value = trim( $value );

		if ( empty( $value ) ) {
			return true;
		}

		switch ( RuleFormatter::name( $parameters, $attribute ) ) {
			case 'pesel':
				return $self->validatePesel( $value );
			case 'regon':
				return $self->validateRegon( $value );
			case 'nip':
				return $self->validateNip( $value );
			case 'pwz':
				return $self->validatePwz( $value );
		}

		return false;
	}

	protected function validateNip( $value ) {
		$value = preg_replace( '/[^\d]/', '', $value );

		if ( ! $this->preValidation( $value, '/^\d{10}$/' ) ) {
			return false;
		}

		$sum      = $this->calculateSum( $value, [6, 5, 7, 2, 3, 4, 5, 6, 7] );
		$checksum = intval( $value[9] );

		return $sum % 11 === $checksum;
	}

	protected function validatePesel( $value ) {
		if ( ! $this->preValidation( $value, '/^\d{11}$/' ) ) {
			return false;
		}

		$sum      = $this->calculateSum( $value, [9, 7, 3, 1, 9, 7, 3, 1, 9, 7] );
		$checksum = intval( $value[10] );

		return $sum % 10 === $checksum;
	}

	protected function validatePwz( $value ) {
		if ( ! $this->preValidation( $value, '/^\d{7}$/' ) ) {
			return false;
		}

		$sum      = $this->calculateSum( $value, [1, 2, 3, 4, 5, 6], 1 );
		$checksum = intval( $value[0] );

		return $sum % 11 == $checksum;
	}

	protected function validateRegon( $value ) {
		if ( ! $this->preValidation( $value, '/^\d{9}$/' ) ) {
			return false;
		}

		$sum      = $this->calculateSum( $value, [8, 9, 2, 3, 4, 5, 6, 7] );
		$modulo   = $sum % 11 !== 10 ? $sum % 11 : 0;
		$checksum = intval( $value[8] );

		return $modulo === $checksum;
	}

	private function calculateSum( $value, $weights, $start = 0 ) {
		$values = is_string( $value ) ? str_split( $value ) : $value;

		return collect( $values )
			->pipe( function ( $collection ) use ( $start ) {
				return $collection->splice( $start );
			} )
			->transform( function ( $value, $key ) use ( $weights ) {
				return isset( $weights[$key] ) ? $value * $weights[$key] : 0;
			} )
			->sum();
	}

	private function preValidation( $value, $pattern, $check_zero = true ) {
		if ( ! preg_match( $pattern, $value ) ) {
			return false;
		}

		$values = str_split( $value );

		if ( $check_zero && array_sum( $values ) === 0 ) {
			return false;
		}

		return true;
	}
}