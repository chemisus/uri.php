<?php

namespace Chemisus\URI;

class URI
{
    const SCHEME = 'scheme';
    const USER = 'user';
    const PASS = 'pass';
    const HOST = 'host';
    const PORT = 'port';
    const PATH = 'path';
    const QUERY = 'query';
    const FRAGMENT = 'fragment';

    const PARTS = [
        self::SCHEME,
        self::USER,
        self::PASS,
        self::HOST,
        self::PORT,
        self::PATH,
        self::QUERY,
        self::FRAGMENT,
    ];

    public static function FromParts($uri)
    {
        $parts = array_merge(array_fill_keys(URI::PARTS, null), $uri);
        $scheme = $parts[URI::SCHEME];
        $user = $parts[URI::USER];
        $pass = $parts[URI::PASS];
        $host = $parts[URI::HOST];
        $port = $parts[URI::PORT];
        $path = $parts[URI::PATH];
        $query = $parts[URI::QUERY];
        $fragment = $parts[URI::FRAGMENT];

        return new URI($scheme, $user, $pass, $host, $port, $path, $query, $fragment);
    }

    /**
     * @param string $uri
     * @return URI
     * @throws InvalidURIException
     */
    public static function FromString(string $uri)
    {
        $parts = parse_url($uri);
        if ($parts === false) {
            throw new InvalidURIException("invalid uri: $uri");
        }
        return self::FromParts($parts);
    }

    private $scheme;
    private $user;
    private $pass;
    private $host;
    private $port;
    private $path;
    private $query;
    private $fragment;

    public function __construct(?string $scheme = null, ?string $user = null, ?string $pass = null, ?string $host = null, ?string $port = null, ?string $path = null, ?string $query = null, ?string $fragment = null)
    {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->pass = $pass;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public function parts(): array
    {
        return array_filter([
            self::SCHEME => $this->scheme,
            self::USER => $this->user,
            self::PASS => $this->pass,
            self::HOST => $this->host,
            self::PORT => $this->port,
            self::PATH => $this->path,
            self::QUERY => $this->query,
            self::FRAGMENT => $this->fragment,
        ]);
    }

    public function toString(): string
    {
        return uri_string($this);
    }

    public function authority(): ?string
    {
        return uri_authority($this);
    }

    public function scheme(): ?string
    {
        return $this->scheme;
    }

    public function setScheme(?string $scheme): URI
    {
        $this->scheme = $scheme;
        return $this;
    }

    public function user(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): URI
    {
        $this->user = $user;
        return $this;
    }

    public function pass(): ?string
    {
        return $this->pass;
    }

    public function setPass(?string $pass): URI
    {
        $this->pass = $pass;
        return $this;
    }

    public function host(): ?string
    {
        return $this->host;
    }

    public function setHost(?string $host): URI
    {
        $this->host = $host;
        return $this;
    }

    public function port(): ?string
    {
        return $this->port;
    }

    public function setPort(?string $port): URI
    {
        $this->port = $port;
        return $this;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): URI
    {
        $this->path = $path;
        return $this;
    }

    public function query(): ?string
    {
        return $this->query;
    }

    public function setQuery(?string $query): URI
    {
        $this->query = $query;
        return $this;
    }

    public function fragment(): ?string
    {
        return $this->fragment;
    }

    public function setFragment(?string $fragment): URI
    {
        $this->fragment = $fragment;
        return $this;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @param array $parts
     * @return URI
     * @throws InvalidURIException
     */
    public function with(array $parts = [])
    {
        return uri(array_merge($this->parts(), $parts));
    }
}
