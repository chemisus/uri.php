<?php

namespace Chemisus\URI;

class MutableChildURI extends ChildURI implements MutableURI
{
    private $child;

    public function __construct(URI $parent, MutableURI $child)
    {
        parent::__construct($parent, $child);
        $this->child = $child;
    }

    public function setScheme(?string $scheme): MutableURI
    {
        $this->child->setScheme($scheme);
        return $this;
    }

    public function setUser(?string $user): MutableURI
    {
        $this->child->setUser($user);
        return $this;
    }

    public function setPass(?string $pass): MutableURI
    {
        $this->child->setPass($pass);
        return $this;
    }

    public function setHost(?string $host): MutableURI
    {
        $this->child->setHost($host);
        return $this;
    }

    public function setPort(?string $port): MutableURI
    {
        $this->child->setPort($port);
        return $this;
    }

    public function setPath(?string $path): MutableURI
    {
        $this->child->setPath($path);
        return $this;
    }

    public function setQuery(?string $query): MutableURI
    {
        $this->child->setQuery($query);
        return $this;
    }

    public function setFragment(?string $fragment): MutableURI
    {
        $this->child->setFragment($fragment);
        return $this;
    }
}