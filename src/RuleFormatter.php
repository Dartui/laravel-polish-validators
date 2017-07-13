<?php

namespace Dartui\PolishValidators;

class RuleFormatter {
	public static function name( $parameters, $attribute ) {
		return isset( $parameters[0] ) ? $parameters[0] : $attribute;
	}
}