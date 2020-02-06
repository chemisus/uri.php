# URI

## Install

    composer require chemisus/uri

## Examples

    $uri = uri("http://example.com:8080/hello?name=chemisus");
    echo $uri->scheme();        # http
    echo $uri->host();          # example.com
    echo $uri->port();          # 8080
    echo $uri->authority();     # example.com:8080
    echo $uri->path();          # /hello
    echo $uri->query();         # name=chemisus
    echo $uri;                  # http://example.com:8080/hello?name=chemisus

    $child = $uri->with([
        URI::SCHEME => 'https',
        URI::PORT => null,
        URI::PATH => '/hello/world'
    ]);
    echo $child->scheme();      # https
    echo $child->host();        # example.com
    echo $child->port();        # 
    echo $child->authority();   # example.com
    echo $child->path();        # /hello/world
    echo $child->query();       # name=chemisus
    echo $child;                # https://example.com/hello/world?name=chemisus
