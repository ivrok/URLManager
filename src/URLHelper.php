<?php

namespace Ivrok\URLManager;

class URLHelper
{
    /**
     * @param string $url
     * @return URL
     */
    public static function parseUrl(string $url)
    {
        $parsedURL = parse_url($url);

        $url = new URL($parsedURL['host']);

        if ($parsedURL['scheme'] === 'https') {
            $url->setHTTPS();
        }

        if (isset($parsedURL['path'])) {
            $url->setPath($parsedURL['path']);
        }

        if (isset($parsedURL['query'])) {

            array_map(function ($queryParam) use ($url) {
                $queryParamAr = explode('=', $queryParam, 2);

                $url->addQueryParameter($queryParamAr[0], $queryParamAr[1] ?? '');

            }, explode('&', $parsedURL['query']));
        }

        return $url;
    }

    /**
     * Check if a protocol is https
     *
     * @param URL $url The URL object to check.
     * @return bool Returns true if protocol is https
     */
    public static function isHTTPS(URL $url)
    {
        return $url->getProtocol() === 'https';
    }

    /**
     * Check if a protocol is http
     *
     * @param URL $url The URL object to check.
     * @return bool Returns true if protocol is http
     */
    public static function isHTTP(URL $url)
    {
        return $url->getProtocol() === 'http';
    }

    /**
     * Check if a specific query parameter exists in the URL.
     *
     * @param URL $url The URL object to check.
     * @param string $key The key of the query parameter to check for.
     * @return bool Returns true if the query parameter exists, otherwise false.
     */
    public static function hasQuery(URL $url, string $key)
    {
        return $url->getQueryParameter($key) !== null;
    }

    /**
     * Check if the path of the URL is exactly the given path.
     *
     * @param URL $url The URL object to check.
     * @param string $path The path to compare against the URL's path.
     * @return bool Returns true if the paths are identical, otherwise false.
     */
    public static function isPath(URL $url, string $path)
    {
        return $url->getPath() === $path;
    }

    /**
     * Check if the path of the URL includes a given substring.
     *
     * @param URL $url The URL object to check.
     * @param string $path The substring to check within the URL's path.
     * @return bool Returns true if the substring is found within the path, otherwise false.
     */
    public static function isPathInclude(URL $url, string $path)
    {
        return strpos($url->getPath(), $path) !== false;
    }

    /**
     * Check if the domain of the URL matches the given domain.
     *
     * @param URL $url The URL object to check.
     * @param string $domain The domain to compare against the URL's domain.
     * @return bool Returns true if the domains match, otherwise false.
     */
    public static function isDomain(URL $url, string $domain)
    {
        return $url->getDomain() === $domain;
    }

    /**
     * Check if the domain of the URL matches the given domain or top domain.
     *
     * @param URL $url The URL object to check.
     * @param array $domains The domains to compare against the URL's domain.
     * @return bool Returns true if the domains match, otherwise false.
     */
    public static function isDomainOrTopDomain(URL $url, string $domain)
    {
        $urlDomainParts = explode('.', $url->getDomain());
        $domainParts = explode('.', $domain);

        $urlDomainPartsReversed = array_reverse($urlDomainParts);
        $domainPartsReversed = array_reverse($domainParts);

        foreach ($domainPartsReversed as $index => $part) {
            if (!isset($urlDomainPartsReversed[$index]) || $urlDomainPartsReversed[$index] !== $part) {
                return false;
            }
        }

        return true;
    }
}
