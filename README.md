# URLManager

`URLManager` is a PHP package designed to facilitate the parsing and management of URLs. It includes two classes, `URL` and `URLHelper`, to handle URL components and parsing respectively.

## Installation

You can install the package via Composer:

```bash
composer require ivrok/urlmanager
```

## Usage

### URL Class

The `URL` class provides methods to set and get URL components such as protocol, domain, and path. It also allows you to add query parameters.

```php
use Ivrok\URLManager\URL;

$url = new URL('example.com');
$url->setHTTPS();
$url->setPath('/index.php');
$url->addQueryParameter('key', 'value');

echo $url; // Outputs: https://example.com/index.php?key=value
```

### URLHelper Class

The URLHelper class includes methods to interact with the URL object:

```php
use Ivrok\URLManager\URLHelper;

$url = URLHelper::parseUrl('https://www.example.com/index.php?key=value');

// Check if a specific query exists
echo URLHelper::hasQuery($url, 'key'); // Outputs: true

// Check if the URL path matches a specific path
echo URLHelper::isPath($url, '/about'); // Outputs: true

// Check if the URL path includes a specific string
echo URLHelper::isPathInclude($url, 'ab'); // Outputs: true

// Check if the domain matches
echo URLHelper::isDomain($url, 'www.example.com'); // Outputs: true

// Check if the domain and top domain matches
echo URLHelper::isDomainOrTopDomain($url, 'example.com'); // Outputs: true
```

## Features

- Set and get URL components like domain, path, and protocol.
- Add single or multiple query parameters to a URL.
- Parse a URL string into a `URL` object.

## License

URLManager is open-source software licensed under the [MIT license](LICENSE).
