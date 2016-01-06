<?php

namespace Gerencianet;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private $options = [
      'client_id' => 'client_id',
      'client_secret' => 'client_secret',
      'url' => 'http://localhost:8082',
    ];

    private $success;

    public function setUp()
    {
        $this->success = json_encode(['access_token' => 'token', 'expires_in' => 500, 'token_type' => 'bearer']);
    }

    /**
     * @test
     */
    public function shouldAuthorizeSuccessfully()
    {
        $request = new Request($this->options);

        $client = $this->getMockBuilder('Client')
                              ->setMethods(array('send', 'createRequest'))
                              ->getMock();

        $response = $this->getMockBuilder('Response')
                          ->setMethods(array('getBody'))
                          ->getMock();

        $response->method('getBody')->willReturn($this->success);

        $client->expects($this->once())
                ->method('send')
                ->willReturn($response);

        $request->client = $client;
        $webResponse = $request->send('POST', '/v1/authorize', ['json' => ['grant_type' => 'client_credentials']]);

        $this->assertEquals($webResponse['access_token'], 'token');
    }

    /**
     * @test
     * @expectedException Gerencianet\Exception\AuthorizationException
     */
    public function shouldThrowExceptionForUnauthorized()
    {
        $request = new Request($this->options);
        // Create a mock and queue two responses.
        $mock = new Mock([
            new Response(401, ['Content-Length' => 100]),
        ]);

        $request->client->getEmitter()->attach($mock);

        $webResponse = $request->send('POST', '/authorize', ['json' => ['grant_type' => 'client_credentials']]);
    }

    /**
     * @test
     * @expectedException Gerencianet\Exception\GerencianetException
     */
    public function shouldThrowExceptionForServerError()
    {
        $request = new Request($this->options);
        // Create a mock and queue two responses.
        $mock = new Mock([
            new Response(500, ['Content-Length' => 100]),
        ]);

        $request->client->getEmitter()->attach($mock);

        $webResponse = $request->send('POST', '/v1/authorize', ['json' => ['grant_type' => 'client_credentials']]);
    }

    /**
     * @test
     */
    public function shouldGetPropertiesCorrectly()
    {
        $request = new Request($this->options);
        $request->client = 'client';
        $this->assertEquals($request->client, 'client');
    }

    /**
     * @test
     */
    public function shouldSetPropertiesCorrectly()
    {
        $request = new Request($this->options);
        $request->client = 'new_client_id';
        $request->notAProp = 'notAProp';

        $this->assertEquals($request->client, 'new_client_id');
        $this->assertEquals($request->notAProp, null);
    }
}
