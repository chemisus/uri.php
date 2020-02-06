<?php

namespace Chemisus\URI;

class ChildURI implements URI
{
    /**
     * @var URI
     */
    private $parent;

    /**
     * @var URI
     */
    private $child;

    public function __construct(URI $parent, URI $child)
    {
        $this->parent = $parent;
        $this->child = $child;
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
        return $this->child->scheme() ?? $this->parent->scheme();
    }

    public function user(): ?string
    {
        return $this->child->user() ?? $this->parent->user();
    }

    public function pass(): ?string
    {
        return $this->child->pass() ?? $this->parent->pass();
    }

    public function host(): ?string
    {
        return $this->child->host() ?? $this->parent->host();
    }

    public function port(): ?string
    {
        return $this->child->port() ?? $this->parent->port();
    }

    public function path(): ?string
    {
        return $this->child->path() ?? $this->parent->path();
    }

    public function query(): ?string
    {
        return $this->child->query() ?? $this->parent->query();
    }

    public function fragment(): ?string
    {
        return $this->child->fragment() ?? $this->parent->fragment();
    }

    /**
     * @param array $parts
     * @return BaseURI|ChildURI|MutableChildURI|URI|null
     * @throws InvalidURIException
     */
    public function with(array $parts = [])
    {
        return uri($this, $parts);
    }

    public function __toString()
    {
        return $this->toString();
    }
}
