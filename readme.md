# Initer

This library reads/writes flat array data from/to `key=value` format compatible with `.ini` and `.env` files.

## Installation

```shell
$ composer require piotrpress/initer
```

## Usage

```php
require __DIR__ . '/vendor/autoload.php';

use PiotrPress\Initer;

$config = new Initer( '.config', [
    'key' => 'value'
] );

echo $config[ 'key' ]; 
$config[ 'key' ] = 'new_value';

$config->save();
```

## Requirements

- PHP >= `7.4` version.
- `Ctype` extension.

## License

[MIT](license.txt)