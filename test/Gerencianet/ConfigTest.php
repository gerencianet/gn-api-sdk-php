<?php

namespace Gerencianet;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetPropertiesCorrectly()
    {
        $property = Config::get('URL');

        $this->assertInternalType('array', $property);

        $property = Config::get('ENDPOINTS');

        $this->assertInternalType('array', $property);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyProperty()
    {
        $property = Config::get('NOTAPROP');

        $this->assertNull($property);
    }

    /**
     * @test
     */
    public function shouldBuildOptionsSuccessfully()
    {
        $options = [
        'client_id' => 'client_id',
        'client_secret' => 'client_secret',
        'url' => 'http://dannielgnapi.gerencianet.com.br:4400',
      ];

        $opt = Config::options($options);

        $this->assertArrayHasKey('sandbox', $opt);
        $this->assertArrayHasKey('debug', $opt);
        $this->assertArrayHasKey('clientId', $opt);
        $this->assertArrayHasKey('clientSecret', $opt);
        $this->assertEquals($opt['sandbox'], false);
    }

    /**
     * @test
     */
    public function shouldBuildOptionsWithoutUrl()
    {
        $options = [
        'client_id' => 'client_id',
        'client_secret' => 'client_secret',
        'sandbox' => true,
      ];

        $opt = Config::options($options);

        $this->assertArrayHasKey('sandbox', $opt);
        $this->assertArrayHasKey('debug', $opt);
        $this->assertArrayHasKey('clientId', $opt);
        $this->assertArrayHasKey('clientSecret', $opt);
        $this->assertEquals($opt['sandbox'], true);
    }
}
