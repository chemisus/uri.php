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

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $fragment;

    public function __construct(
        string $scheme = null,
        string $user = null,
        string $pass = null,
        string $host = null,
        string $port = null,
        string $path = null,
        string $query = null,
        string $fragment = null
    ) {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->pass = $pass;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    /**
     * @param array $parts
     * @return URI
     */
    public function with(array $parts = [])
    {
        return self::FromParts(array_merge($this->parts(), $parts));
    }

    /**
     * Returns an array containing the URI components and their values.
     *
     * Any null components will be removed.
     *
     * @return array
     */
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

    /**
     * Returns the URI in string format.
     *
     * URI pattern: [scheme:][//[user[:pass]@]host[:port]][path][?query][#fragment]
     *
     * @return string
     */
    public function toString(): string
    {
        $scheme = postfix($this->scheme(), ":");
        $authority = wrap('//', $this->authority());
        $path = ltrim($this->path(), '/');
        $query = wrap('?', $this->query());
        $fragment = wrap('#', $this->fragment());
        return $scheme . implode('/', array_filter([$authority, $path])) . $query . $fragment;
    }

    /**
     * Returns the URI authority.
     *
     * Authority pattern: [user[:pass]@]host[:port]
     *
     * @return string|null
     */
    public function authority(): ?string
    {
        return postfix($this->user(), wrap(':', $this->pass()) . '@') . $this->host() . wrap(':', $this->port());
    }

    /**
     * Returns the URI scheme.
     *
     * @return string|null
     */
    public function scheme(): ?string
    {
        return $this->scheme;
    }

    /**
     * Returns the URI user.
     *
     * @return string|null
     */
    public function user(): ?string
    {
        return $this->user;
    }

    /**
     * Returns the URI pass.
     *
     * @return string|null
     */
    public function pass(): ?string
    {
        return $this->pass;
    }

    /**
     * Returns the URI host.
     *
     * @return string|null
     */
    public function host(): ?string
    {
        return $this->host;
    }

    /**
     * Returns the URI port.
     *
     * @return string|null
     */
    public function port(): ?string
    {
        return $this->port;
    }

    /**
     * Returns the URI path.
     *
     * @return string|null
     */
    public function path(): ?string
    {
        return $this->path;
    }

    /**
     * Returns the URI query.
     *
     * @return string|null
     */
    public function query(): ?string
    {
        return $this->query;
    }

    /**
     * Returns the URI fragment.
     *
     * @return string|null
     */
    public function fragment(): ?string
    {
        return $this->fragment;
    }

    /**
     * Returns the URI in string format.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
