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

function uri_authority(URI $uri)
{
    return postfix($uri->user(), wrap(':', $uri->pass()) . '@') . $uri->host() . wrap(':', $uri->port());
}

function uri_string(URI $uri)
{
    $scheme = postfix($uri->scheme(), ":");
    $authority = wrap('//', uri_authority($uri));
    $path = $uri->path();
    $query = wrap('?', $uri->query());
    $fragment = wrap('#', $uri->fragment());
    return implode('', [$scheme, $authority, $path, $query, $fragment]);
}
