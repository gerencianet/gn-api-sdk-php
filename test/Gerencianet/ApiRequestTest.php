<?php

namespace Gerencianet;

use Gerencianet\Exception\AuthorizationException;

class ApiRequestTest extends \PHPUnit_Framework_TestCase
{
    private $options = [
      'client_id' => 'client_id',
      'client_secret' => 'client_secret',
      'url' => 'http://localhost:4404',
    ];

    private $authorization;
    private $response;

    public function setUp()
    {
        $this->authorization = json_encode(['access_token' => 'token', 'expires_in' => 500, 'token_type' => 'bearer']);
        $this->response = json_encode(['code' => 200]);
    }

    /**
     * @test
     */
    public function shouldRequestSuccessfully()
    {
        $request = $this->getMockBuilder('Request')
                              ->setMethods(array('send'))
                              ->disableOriginalConstructor()
                              ->getMock();
        $request->method('send')
                ->willReturn(json_decode($this->response));

        $auth = $this->getMockBuilder('Auth')
                              ->setMethods(array('authorize'))
                              ->disableOriginalConstructor()
                              ->getMock();

        $auth->method('authorize')
                ->willReturn(json_decode($this->authorization));
        $auth->expires = time() + 500;
        $auth->accessToken = 'accessToken';

        $api = new ApiRequest($this->options);
        $api->request = $request;
        $api->auth = $auth;
        $response = $api->send('POST', '/v1/charge', []);

        $this->assertEquals($response->code, 200);
    }

    /**
     * @test
     */
    public function shouldReauthorizeExpiredToken()
    {
        $request = $this->getMockBuilder('Request')
                            ->setMethods(array('send'))
                            ->disableOriginalConstructor()
                            ->getMock();
        $request->method('send')
              ->willReturn(json_decode($this->response));

        $auth = $this->getMockBuilder('Auth')
                            ->setMethods(array('authorize'))
                            ->disableOriginalConstructor()
                            ->getMock();

        $auth->method('authorize')
              ->willReturn(json_decode($this->authorization));

        $auth->expires = 500;
        $auth->accessToken = 'accessToken';

        $api = new ApiRequest($this->options);
        $api->request = $request;
        $api->auth = $auth;
        $response = $api->send('POST', '/v1/charge', []);

        $this->assertEquals($response->code, 200);
    }

    /**
     * @test
     */
    public function shouldReauthorizeWhenServerRespondsWithAuthError()
    {
        $request = $this->getMockBuilder('Request')
                            ->setMethods(array('send'))
                            ->disableOriginalConstructor()
                            ->getMock();
        $exception = new AuthorizationException('401', 'Unauthorized');
        $request->method('send')
              ->will($this->onConsecutiveCalls(
                $this->throwException($exception),
                json_decode($this->response)
              )
            );

        $auth = $this->getMockBuilder('Auth')
                            ->setMethods(array('authorize'))
                            ->disableOriginalConstructor()
                            ->getMock();

        $auth->method('authorize')
              ->willReturn(json_decode($this->authorization), json_decode($this->authorization));

        $auth->expires = time() + 500;
        $auth->accessToken = 'accessToken';

        $api = new ApiRequest($this->options);
        $api->request = $request;
        $api->auth = $auth;
        $response = $api->send('POST', '/v1/charge', []);

        $this->assertEquals($response->code, 200);
    }

    /**
     * @test
     */
    public function shouldGetPropertiesCorrectly()
    {
        $api = new ApiRequest($this->options);

        $this->assertNotNull($api->request);
        $this->assertNotNull($api->auth);
        $this->assertNull($api->notAProp);
    }

    /**
     * @test
     */
    public function shouldSetPropertiesCorrectly()
    {
        $api = new ApiRequest($this->options);
        $api->request = 'request';
        $api->notAProp = 'notAProp';

        $this->assertEquals($api->request, 'request');
        $this->assertNull($api->notAProp);
    }
}
