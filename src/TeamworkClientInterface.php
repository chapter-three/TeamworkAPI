<?php

namespace ChapterThree\TeamworkAPI;

use GuzzleHttp\Command\ServiceClientInterface;

interface TeamworkClientInterface extends ServiceClientInterface {

    /**
     * Use this factory method to instantiate the API client.
     *
     * @param array $config
     *  The configuration array for the library.
     *  - base_uri    (Required) The base uri for your accounts API endpoint.
     *  - token       (Required) API Token from your Teamwork account (Found under "My Account").
     *
     * @throws \InvalidArgumentException
     *
     * @return \ChapterThree\TeamworkAPI\TeamworkClientInterface
     */
    public static function create($config = []);

}
