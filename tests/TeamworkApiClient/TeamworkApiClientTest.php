<?php

namespace ChapterThree\TeamworkAPI\Tests\TeamworkApiClient;

use ChapterThree\TeamworkAPI\TeamworkClient;
use ChapterThree\TeamworkAPI\TeamworkClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Tests\Server;
use PHPUnit_Framework_TestCase;

/**
 * @group teamwork-unit
 * @coversDefaultClass \ChapterThree\TeamworkAPI\TeamworkClient
 */
class TeamworkApiClientTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \ChapterThree\TeamworkAPI\TeamworkClient
     */
    public $client;

    public function setUp()
    {
        parent::setUp();

        // Start the guzzle test server.
        Server::start();
        register_shutdown_function(function(){Server::stop();});

        $this->client = TeamworkClient::create([
            'base_uri' => Server::$url,
            'api_token' => $_SERVER['API_TOKEN'],
        ]);
    }

    /**
     * @covers ::create
     */
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

    /**
     * Tests the account without actually making an external api call.
     */
    public function testAuthentication()
    {
        Server::enqueue([$this->getJsonResponse(200, '{"STATUS":"OK","account":{"companyname":"Foo","id":"12345","code":"foo"}}')]);

        $this->client->Account();
        $request = Server::received()[0];

        self::assertNotEmpty($request->getHeader('Authorization'));
        self::assertEquals('Basic '. base64_encode("{$_SERVER['API_TOKEN']}:xxx"), $request->getHeader('Authorization')[0]);
    }

    /**
     * Tests the account without actually making an external api call.
     */
    public function testAccountCommand()
    {

        $response_data = [
            'STATUS' => 'OK',
            'account' => [
                'companyname' => 'Foo',
                'id'          => '12345',
                'code'        => 'foo',
            ],
        ];

        Server::enqueue([$this->getJsonResponse(200, $response_data)]);

        $client = TeamworkClient::create([
            'base_uri' => Server::$url,
            'api_token' => $_SERVER['API_TOKEN'],
        ]);

        $result = $client->Account()->toArray();

        self::assertArraySubset([
            'STATUS' => 'OK'
        ], $result);

        self::assertNotEmpty($result['account']['companyname']);
    }

    /**
     * Converts an array to a stream resource.
     *
     * @param array|string $resource_data
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function getJsonResponse($status_code, $resource_data) {
        $encoded = is_string($resource_data) ? $resource_data : json_encode($resource_data, JSON_UNESCAPED_SLASHES);

        return new Response($status_code, ['Content-Length' => strlen($encoded)], $encoded);
    }

}
