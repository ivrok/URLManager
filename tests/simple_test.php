<?php

use Ivrok\URLManager\URLHelper;

require_once(realpath(__DIR__ . '/..') . '/vendor/autoload.php');

function assertTrue($testName, $result) {
    if (!$result) {
        throw new \Exception($testName . ' assertion failed');
    }
    echo $testName . '- OK'. PHP_EOL;
}

$testUrlString = 'https://www.google.com/search/index.php?q=ivrok&oq=ivrok';
$url = URLHelper::parseUrl($testUrlString);

assertTrue('URL Protocol test', $url->getProtocol() === 'https');
assertTrue('URL Domain test', $url->getDomain() === 'www.google.com');
assertTrue('URL Path test', $url->getPath() === '/search/index.php');
assertTrue('URL Query test', $url->getQueryParameter('q') === 'ivrok');
assertTrue('URL Relative URL test', $url->getRelativeURL() === '/search/index.php?q=ivrok&oq=ivrok');

assertTrue('URLHelper protocol https test', URLHelper::isHTTPS($url));
assertTrue('URLHelper protocol http test', URLHelper::isHTTP($url) === false);
assertTrue('URLHelper domain test', URLHelper::isDomain($url, 'www.google.com'));
assertTrue('URLHelper top domain test', URLHelper::isDomainOrTopDomain($url, 'google.com'));
assertTrue('URLHelper path test', URLHelper::isPath($url, '/search/index.php'));
assertTrue('URLHelper relative URL test', URLHelper::isPathInclude($url, '/search/'));
assertTrue('URLHelper query test', URLHelper::hasQuery($url, 'q'));
