# SMS Traffic API with Laravel Support

[SMS Traffic](http://www.smstraffic.ru/) is full-cycle SMS aggregator. This project is an implementation of API by HTTP
Protocol.

##  Install via composer

```bash
composer require danbka33/smstraffic-api-laravel
```

This package makes use of [Laravels package auto-discovery mechanism](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518).

If for some reason you want manually control this:
- add the package to the `extra.laravel.dont-discover` key in `composer.json`, e.g.
  ```json
  "extra": {
    "laravel": {
      "dont-discover": [
        "danbka33/smstraffic-api-laravel"
      ]
    }
  }
  ```
- Add the following class to the `providers` array in `config/app.php`:
  ```php
  \Danbka33\SmsTrafficApi\Providers\SmsTrafficServiceProvider::class,
  ```

## Environment Variables

```dotenv
SMS_TRAFFIC_LOGIN=login
SMS_TRAFFIC_PASSWORD=password
SMS_TRAFFIC_ORIGINATOR=originator
```

## Lumen

To use the included config, copy it over to your config folder.

```bash
mkdir -p config
cp vendor/danbka33/smstraffic-api-laravel/src/config/sms-traffic.php config/
```

Register the config file within your bootstrap/app.php file:
```php
$app->configure('sms-traffic');
```

Register the service provider in your bootstrap/app.php file:
```php
$app->register(\Danbka33\SmsTrafficApi\Providers\SmsTrafficServiceProvider::class);
```

## Usage

```php
use Danbka33\SmsTrafficApi\Client;
use Danbka33\SmsTrafficApi\Sms\Sms;

$client = app()->get(Client::class);
$result = $client->send(new Sms($phone, $message));
```

## Publish default config file

```bash
php artisan vendor:publish --tag=sms-traffic-config
```

```php
return [
    'login' => env('SMS_TRAFFIC_LOGIN', ''),
    'password' => env('SMS_TRAFFIC_PASSWORD', ''),
    'originator' => env('SMS_TRAFFIC_ORIGINATOR', ''),
];
```

## License

The SMS Traffic API with Laravel Support is open-sourced software licensed under the MIT license
