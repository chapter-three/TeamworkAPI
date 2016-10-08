<?php

namespace ChapterThree\TeamworkAPI\Tests\TeamworkApiClient;

use ChapterThree\TeamworkAPI\TeamworkClient;
use ChapterThree\TeamworkAPI\TeamworkClientInterface;
use PHPUnit_Framework_TestCase;

/**
 * @group teamwork-unit
 */

class TeamworkApiClientTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \ChapterThree\TeamworkAPI\TeamworkClientInterface
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = TeamworkClient::create([
            'base_uri' => $_SERVER['BASE_URI'],
            'api_token' => $_SERVER['API_TOKEN'],
        ]);
    }

    public function testFactoryMethod()
    {
        $client = TeamworkClient::create([
            'base_uri' => $_SERVER['BASE_URI'],
            'api_token' => $_SERVER['API_TOKEN'],
        ]);

        self::assertInstanceOf(TeamworkClientInterface::class, $client);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Config is missing the following keys
     */
    public function testFactoryFailure()
    {
        $client = TeamworkClient::create([
            'base_uri' => $_SERVER['BASE_URI'],
        ]);

        self::assertInstanceOf(TeamworkClientInterface::class, $client);
    }

}
