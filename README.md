# Laravel Polish Validators

## Available rules

Name | Description | Example | Field or Parameter
:-: | - | - | - 
PESEL | Universal Electronic System for Registration of the Population | 73021604589 | pesel
NIP | VAT identification number (without leading PL) | 123-123-12-12 | nip
REGON | Taxpayer Identification Number | 158395862 | regon
PWZ | Doctors license number | 6249056 | pwz

## Instalation

Require this package with composer:

```shell
composer require dartui/polish-validators
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

> Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider

```php
Dartui\PolishValidators\ServiceProvider::class
```

Now you need to add message to language files in `resources/lang/XX/validation.php`

```php
'valid' => 'The :attribute is not valid.',
```

## Usage

By default validation type is chosen by field name. If you want you can force validation type by giving `parameter` after colon in rule.

```php
$data = [
	'pesel'         => '01234567890',
	'some_field'    => '123123123',
	'another_field' => '12345678',
	'pwz'           => '1311111',
];

$validator = Validator::make( $data, [
	'pesel'         => 'valid',
	'some_field'    => 'valid:nip',
	'another_field' => 'valid:regon',
	'pwz'           => 'valid',
] );

$validator->valid();
```
