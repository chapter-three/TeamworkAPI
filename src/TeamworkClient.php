<?php

namespace ChapterThree\TeamworkAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;

class TeamworkClient extends GuzzleClient implements TeamworkClientInterface {

    /**
     * {@inheritdoc}
     */
    public static function create($config = []) {

        // Required config.
        $required = [
            'base_uri',
            'api_token',
        ];

        // Enforce required configuration.
        if ($missing = array_diff($required, array_keys($config))) {
            throw new \InvalidArgumentException('Config is missing the following keys: ' . implode(', ', $missing));
        }

        // Load the service description file.
        $service_description = new Description(
            ['baseUrl' => $config['base_uri']] + (array) json_decode(file_get_contents(__DIR__ . '/service.json'), TRUE)
        );

        // Creates the client and sets the default request headers and authentication.
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'auth' =>  [$config['api_token'], 'xxx'],
        ]);
        return new static($client, $service_description, NULL, NULL, NULL, $config);
    }

}
