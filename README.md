# SMS Traffic API

[SMS Traffic](http://www.smstraffic.ru/) is full-cycle SMS aggregator. This project is an implementation of API by HTTP
Protocol.

## Install


```bash
composer require danbka33/smstraffic-api-laravel
```

Add variables to .env

```dotenv
SMS_TRAFFIC_LOGIN=login
SMS_TRAFFIC_PASSWORD=password
SMS_TRAFFIC_ORIGINATOR=originator
```

## Usage

```php
use Danbka33\SmsTrafficApi\Client;
use Danbka33\SmsTrafficApi\Sms\Sms;

$client = app()->get(Client::class);
$result = $client->send(new Sms($phone, $message));
```

## Publish config file

```bash
php artisan vendor:publish --tag=sms-traffic-config
```

