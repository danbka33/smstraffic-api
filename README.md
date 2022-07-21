# SMS Traffic API

[SMS Traffic](http://www.smstraffic.ru/) is full-cycle SMS aggregator. This project is an implementation of API by HTTP Protocol.

Usage:

```php
    
    use Danbka33\SmsTrafficApi\Client;
    use Danbka33\SmsTrafficApi\Sms\Sms;

    $client = new Client('login', 'password', 'originator');
    $result = $client->send(new Sms('Phone', 'Message'));

```

## Documentation
