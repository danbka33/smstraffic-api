<?php
namespace Danbka33\SmsTrafficApi\Tests;

use Danbka33\SmsTrafficApi\Client;
use Danbka33\SmsTrafficApi\Exception\ParsingException;
use Danbka33\SmsTrafficApi\Exception\SendingException;
use Danbka33\SmsTrafficApi\Sms\Sms;
use Danbka33\SmsTrafficApi\Transport\TransportInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 */
class ClientTest extends TestCase
{
    /**
     * @throws \Danbka33\SmsTrafficApi\Exception\TransportException
     */
    public function testSend()
    {
        $transportMock = $this->createMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>OK</result><code>0</code><description>queued 2 messages</description> <message_infos><message_info> <phone>71112223456</phone> <sms_id>1000472891</sms_id></message_info></message_infos></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $result = $client->send(new Sms('Phone', 'Message'));
        $this->assertEquals(71112223456, $result['message_infos']['message_info']['phone']);
    }

    /**
     * @expectedException \Danbka33\SmsTrafficApi\Exception\ParsingException
     */
    public function testParsingException()
    {
        $this->expectException(ParsingException::class);

        $transportMock = $this->createMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>OK</result><code1>0</code1><description>queued 1 messages</description></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $client->send(new Sms('Phone', 'Message'));
    }

    /**
     * @expectedException \Danbka33\SmsTrafficApi\Exception\SendingException
     * @expectedExceptionCode 401
     * @expectedExceptionMessage login param is missing
     */
    public function testSendingException()
    {
        $this->expectException(SendingException::class);

        $transportMock = $this->createMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>ERROR</result><code>401</code><description>login param is missing</description></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $client->send(new Sms('Phone', 'Message'));
    }

    /**
     * @throws \Danbka33\SmsTrafficApi\Exception\TransportException
     */
    public function testCallbacks()
    {
        $transportMock = $this->createMock(TransportInterface::class);
        $transportMock->method('doRequest')->willReturn('<?xml version="1.0" ?><reply><result>OK</result><code>0</code><description>queued 1 messages</description></reply>');

        $client = new Client('login', 'password', 'originator');
        $client->setTransport($transportMock);
        $phpunit = $this;
        $client->setPreRequestCallback(function ($params, $url) use ($phpunit) {
            $phpunit->assertEquals(
                ["rus" => 5, "phones" => "Phone", "message" => "Message", "login" => "login", "password" => "password", "originator" => "originator"],
                $params
            );
            $phpunit->assertEquals(Client::DEFAULT_API_URL, $url);
        });
        $client->setPostRequestCallback(function ($result, $params, $url) use ($phpunit) {
            $phpunit->assertEquals(["result" => "OK", "code" => "0", "description" => "queued 1 messages"], $result);
            $phpunit->assertEquals(
                ["rus" => 5, "phones" => "Phone", "message" => "Message", "login" => "login", "password" => "password", "originator" => "originator"],
                $params
            );
            $phpunit->assertEquals(Client::DEFAULT_API_URL, $url);
        });
        $client->send(new Sms('Phone', 'Message'));
    }
}
