<?php

namespace Ivrok\URLManager;

class URL
{
    private string $protocol;
    private string $domain;
    private string $path;
    private array $queryParameters = [];

    public function __construct(string $domain)
    {
        $this->setDomain($domain);;
        $this->setPath('/');

        $this->setHTTP();

        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443) {
            $this->setHTTPS();
        }
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    public function addQueryParameter(string $key, string $value)
    {
        $this->queryParameters[$key] = $value;

        return $this;
    }

    public function addQueryParameters(array $queryParameters)
    {
        foreach ($queryParameters as $key => $value) {
            if (is_string($value) === false) {
                $value = var_export($value, true);
            }
            $this->addQueryParameter($key, $value);
        }

        return $this;
    }

    public function removeQueryParameter(string $key)
    {
        unset($this->queryParameters[$key]);
    }

    public function setHTTPS()
    {
        $this->protocol = 'https';

        return $this;
    }

    public function setHTTP()
    {
        $this->protocol = 'http';

        return $this;
    }

    public function getURL()
    {
        $url = $this->protocol . '://' . $this->domain . $this->path;
        if ($this->queryParameters) {
            $url .= '?' . http_build_query($this->queryParameters, null, '&', PHP_QUERY_RFC3986);
        }

        return $url;
    }

    public function getRelativeURL()
    {
        $url = $this->path;
        if ($this->queryParameters) {
            $url.= '?'. http_build_query($this->queryParameters, null, '&', PHP_QUERY_RFC3986);
        }

        return $url;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    public function getQueryParameter(string $key)
    {
        return $this->queryParameters[$key]?? null;
    }

    public function __toString()
    {
        return $this->getURL();
    }
}
