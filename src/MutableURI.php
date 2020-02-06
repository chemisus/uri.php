<?php

namespace Chemisus\URI;

interface MutableURI extends URI
{
    public function setScheme(?string $scheme): self;

    public function setUser(?string $user): self;

    public function setPass(?string $pass): self;

    public function setHost(?string $host): self;

    public function setPort(?string $port): self;

    public function setPath(?string $path): self;

    public function setQuery(?string $query): self;

    public function setFragment(?string $fragment): self;
}
