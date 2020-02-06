<?php

namespace Chemisus\URI;

function wrap($prefix, $string, $postfix = "")
{
    return $string ? $prefix . $string . $postfix : $string;
}

function postfix($string, $postfix = "")
{
    return $string ? $string . $postfix : $string;
}

/**
 * @param mixed $uri
 * @return URI
 * @throws InvalidURIException
 */
function uri($uri = [])
{
    if (is_array($uri)) {
        $uri = URI::FromParts($uri);
    }

    if (!$uri) {
        return null;
    }

    if (is_string($uri)) {
        $uri = URI::FromString($uri);
    }

    if ($uri instanceof URI) {
        return $uri;
    }

    throw new InvalidURIException("invalid uri");
}
