<?php

namespace Chemisus\URI;

interface URI
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
        self::FRAGMENT
    ];

    public function toString(): ?string;

    public function authority(): ?string;

    public function scheme(): ?string;

    public function user(): ?string;

    public function pass(): ?string;

    public function host(): ?string;

    public function port(): ?string;

    public function path(): ?string;

    public function query(): ?string;

    public function fragment(): ?string;
}
