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
 * @param mixed|null $child
 * @return BaseURI|ChildURI|MutableChildURI|URI|null
 * @throws InvalidURIException
 */
function uri($uri = [], $child = null)
{
    if ($uri === null) {
        return null;
    }

    $child = uri($child);

    if (is_string($uri)) {
        $uri = BaseURI::FromString($uri);
    }

    if (is_array($uri)) {
        $uri = BaseURI::FromParts($uri);
    }

    if ($uri instanceof URI) {
        return $child ? ($child instanceof MutableURI ? new MutableChildURI($uri, $child) : new ChildURI($uri, $child)) : $uri;
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
