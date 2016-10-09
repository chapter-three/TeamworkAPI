[![Build Status](https://travis-ci.org/chapter-three/TeamworkAPI.svg?branch=master)](https://travis-ci.org/chapter-three/TeamworkAPI)

# TeamworkAPI

## Installation

The suggested way to include this library in your project is using composer.

```javascript
{
    "require": {
        "chapter-three/teamwork-api": "dev-master"
    }
}
```


## API Token

Your API token can be found by logging into your TeamworkPM account, clicking your avatar in the top right and choosing Edit my details. On the API tab of the dialog click the "Show your token" at the bottom (under "API Authentication tokens").

## Helpful Links

- http://developer.teamwork.com/introduction
- http://developer.teamwork.com/secrettips

## Contributing

This library uses guzzle 6+ service description in the json format. Command are extracted from the `operations` section of the `service.json` file. Most of the commands are yet missing but they are easy to describe. Besides adding the command it would be nice to have a test for each command to make sure it loads.

## Testing

The command for running the tests is in the `.travis.yml` file (also below). The `teamwork-api-integration` test group is an API integration test. You wouldn't typically want to run this type of test for testing the library because it makes http requests to the actual server but you can use them in a controlled environment to test the API.

```bash
vendor/bin/phpunit --exclude-group=teamwork-api-integration -c phpunit.xml.dist
```
