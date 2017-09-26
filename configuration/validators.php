<?php

use Respect\Validation\Validator as v;

$usernameValidator = v::alnum()->noWhitespace()->length(1, 10);
$ageValidator = v::numeric()->positive()->between(1, 20);
$validators = array(
		"name" => $usernameValidator
		,'name' => $ageValidator
);


$nameValidator = v::alnum()->noWhitespace()->notOptional();
$BooleanMandatoryValidator = v::boolVal()->notOptional();

$PartnerValidators = array(
		"name" => $nameValidator
		,'is_active' => $BooleanMandatoryValidator
);
