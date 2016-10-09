<?php

namespace ChapterThree\TeamworkAPI\Tests\TeamworkApiClient;

use ChapterThree\TeamworkAPI\TeamworkClient;
use ChapterThree\TeamworkAPI\TeamworkClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Tests\Server;
use PHPUnit_Framework_TestCase;

/**
 * @group teamwork-unit
 */

class TeamworkApiClientTest extends PHPUnit_Framework_TestCase {

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
     * @param array $resource_data
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function getJsonResponse($status_code, $resource_data) {
        $encoded = json_encode($resource_data, JSON_UNESCAPED_SLASHES);
        // Convert the JSON to a resource.
        $handle = fopen('php://temp','r+');
        fwrite($handle, $encoded);
        rewind($handle);

        return new Response($status_code, ['Content-Length' => strlen($encoded)], new Stream($handle));
    }

}
