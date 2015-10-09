<?php

namespace Gerencianet;

use GuzzleHttp\Client;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    private $options = [
      'client_id' => 'client_id',
      'client_secret' => 'client_secret',
      'url' => 'http://localhost:4404',
    ];

    private $success;

    public function setUp()
    {
        $this->success = json_encode(['access_token' => 'token', 'expires_in' => 500, 'token_type' => 'bearer']);
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Client id or secret not found
     */
    public function shouldNotCreateAuthWithoutCredentials()
    {
        new Auth([]);
    }

    /**
     * @test
     */
    public function shouldAuthorizeSuccessfully()
    {
        $auth = new Auth($this->options);

        $request = $this->getMockBuilder('Request')
                              ->setMethods(array('send'))
                              ->disableOriginalConstructor()
                              ->getMock();
        $request->method('send')
                ->willReturn(json_decode($this->success, true));

        $auth->request = $request;
        $auth->authorize();

        $this->assertEquals($auth->accessToken, 'token');
        $this->assertGreaterThan(500, $auth->expires);
        $this->assertEquals($auth->tokenType, 'bearer');
    }

    /**
     * @test
     */
    public function shouldGetPropertiesCorrectly()
    {
        $auth = new Auth($this->options);
        $this->assertEquals($auth->clientId, 'client_id');
        $this->assertEquals($auth->clientSecret, 'client_secret');
        $this->assertEquals($auth->notAProp, null);
    }

    /**
     * @test
     */
    public function shouldSetPropertiesCorrectly()
    {
        $auth = new Auth($this->options);
        $auth->clientId = 'new_client_id';
        $auth->clientSecret = 'new_client_secret';
        $auth->notAProp = 'notAProp';

        $this->assertEquals($auth->clientId, 'new_client_id');
        $this->assertEquals($auth->clientSecret, 'new_client_secret');
        $this->assertEquals($auth->notAProp, null);
    }
}
