<?php

namespace ChapterThree\TeamworkAPI;

use GuzzleHttp\Command\ServiceClientInterface;

interface TeamworkClientInterface extends ServiceClientInterface {

    /**
     * Use this factory method to instantiate the API client.
     *
     * @param array
     *  The configuration array for the library.
     *  - base_uri    (Required) The base uri for the API endpoint.
     *  - foo         (Required) ...
     */
  public static function create($config = []);

}
