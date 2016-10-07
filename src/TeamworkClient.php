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
        // Load the service description file.
        $service_description = new Description(
            ['baseUrl' => $config['base_uri']] + (array) json_decode(file_get_contents(__DIR__ . '/service.json'), TRUE)
        );

        return new static(new Client(), $service_description, NULL, NULL, NULL, $config);
    }

}
