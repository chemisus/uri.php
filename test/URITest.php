<?php

namespace Chemisus\URI;

use PHPUnit\Framework\TestCase;

class URITest extends TestCase
{
    public function dataProvider()
    {
        return [
            [
                'a://b:c@d:5/f/g?h#i',
                [
                    'scheme' => 'a',
                    'user' => 'b',
                    'pass' => 'c',
                    'host' => 'd',
                    'port' => '5',
                    'path' => '/f/g',
                    'query' => 'h',
                    'fragment' => 'i',
                ],
                'b:c@d:5',
            ],
            [
                'mailto:test@example.com',
                [
                    'scheme' => 'mailto',
                    'path' => 'test@example.com',
                ],
            ],
            [
                'ftp://user@example.com',
                [
                    'scheme' => 'ftp',
                    'user' => 'user',
                    'host' => 'example.com',
                ],
                'user@example.com',
            ],
        ];
    }

    /**
     * @param URI $uri
     * @param string $string
     * @param array $parts
     */
    public function verify(URI $uri, string $string, array $parts)
    {
        $this->assertEquals(array_key_exists('scheme', $parts) ? $parts['scheme'] : null, $uri->scheme());
        $this->assertEquals(array_key_exists('user', $parts) ? $parts['user'] : null, $uri->user());
        $this->assertEquals(array_key_exists('pass', $parts) ? $parts['pass'] : null, $uri->pass());
        $this->assertEquals(array_key_exists('host', $parts) ? $parts['host'] : null, $uri->host());
        $this->assertEquals(array_key_exists('port', $parts) ? $parts['port'] : null, $uri->port());
        $this->assertEquals(array_key_exists('path', $parts) ? $parts['path'] : null, $uri->path());
        $this->assertEquals(array_key_exists('query', $parts) ? $parts['query'] : null, $uri->query());
        $this->assertEquals(array_key_exists('fragment', $parts) ? $parts['fragment'] : null, $uri->fragment());
        $this->assertEquals($string, $uri->toString());
        $this->assertEquals($string, (string)$uri);
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @throws InvalidURIException
     */
    public function testString(string $string, array $parts)
    {
        $this->verify(uri($string), $string, $parts);
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @throws InvalidURIException
     */
    public function testParts(string $string, array $parts)
    {
        $this->verify(uri($parts), $string, $parts);
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @throws InvalidURIException
     */
    public function testSets(string $string, array $parts)
    {
        $uri = uri();
        array_key_exists('scheme', $parts) ? $uri->setScheme($parts['scheme']) : null;
        array_key_exists('user', $parts) ? $uri->setUser($parts['user']) : null;
        array_key_exists('pass', $parts) ? $uri->setPass($parts['pass']) : null;
        array_key_exists('host', $parts) ? $uri->setHost($parts['host']) : null;
        array_key_exists('port', $parts) ? $uri->setPort($parts['port']) : null;
        array_key_exists('path', $parts) ? $uri->setPath($parts['path']) : null;
        array_key_exists('query', $parts) ? $uri->setQuery($parts['query']) : null;
        array_key_exists('fragment', $parts) ? $uri->setFragment($parts['fragment']) : null;
        $this->verify($uri, $string, $parts);
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @param string|null $authority
     * @throws InvalidURIException
     */
    public function testAuthority(string $string, array $parts, string $authority = null)
    {
        $uri = uri($parts);
        $this->assertEquals($authority, $uri->authority());
    }

    /**
     * @throws InvalidURIException
     */
    public function testInvalidURIString()
    {
        $this->expectException(InvalidURIException::class);
        uri('http://');
    }

    /**
     * @throws InvalidURIException
     */
    public function testInvalidURIObject()
    {
        $this->expectException(InvalidURIException::class);
        uri((object)[]);
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @param string|null $authority
     * @throws InvalidURIException
     */
    public function testWithChild(string $string, array $parts, string $authority = null)
    {
        $uri = uri([])->with($parts);
        $this->verify($uri, $string, $parts);
        $this->assertEquals($authority, $uri->authority());
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @param string|null $authority
     * @throws InvalidURIException
     */
    public function testWithParent(string $string, array $parts, string $authority = null)
    {
        $uri = uri($parts)->with([]);
        $this->verify($uri, $string, $parts);
        $this->assertEquals($authority, $uri->authority());
    }


    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param array $parts
     * @throws InvalidURIException
     */
    public function testSetRelative(string $string, array $parts)
    {
        $uri = uri()->with()->with();
        array_key_exists('scheme', $parts) ? $uri->setScheme($parts['scheme']) : null;
        array_key_exists('user', $parts) ? $uri->setUser($parts['user']) : null;
        array_key_exists('pass', $parts) ? $uri->setPass($parts['pass']) : null;
        array_key_exists('host', $parts) ? $uri->setHost($parts['host']) : null;
        array_key_exists('port', $parts) ? $uri->setPort($parts['port']) : null;
        array_key_exists('path', $parts) ? $uri->setPath($parts['path']) : null;
        array_key_exists('query', $parts) ? $uri->setQuery($parts['query']) : null;
        array_key_exists('fragment', $parts) ? $uri->setFragment($parts['fragment']) : null;
        $this->verify($uri, $string, $parts);
    }

    /**
     * @throws InvalidURIException
     */
    public function testNull()
    {
        $this->assertNull(uri(""));
    }

}
