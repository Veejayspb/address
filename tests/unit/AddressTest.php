<?php

use Codeception\Test\Unit;
use veejay\address\Address;

class AddressTest extends Unit
{
    /**
     * Key - input data (absolute url)
     * Value - relative part of url
     * @var array
     */
    private $data = [
        'http://domain.ru:80/index.php?param=1#anchor' => '/index.php?param=1#anchor',
        'http://domain.ru:80/index.php?param=1' => '/index.php?param=1',
        'http://domain.ru:80/index.php' => '/index.php',
        'http://domain.ru:80/' => '/',
    ];

    public function testUrl()
    {
        foreach ($this->data as $abs => $rel) {
            $address = new Address($abs);
            $this->assertEquals($abs, $address->abs());
            $this->assertEquals($rel, $address->rel());
        }
    }

    public function testCustom()
    {
        $address = new Address('http://domain.ru:80/index.php?param=1#anchor');

        $a = clone $address;
        $a->scheme = null;
        $this->assertEquals('/index.php?param=1#anchor', $a->abs());

        $a = clone $address;
        $a->host = null;
        $this->assertEquals('/index.php?param=1#anchor', $a->abs());

        $a = clone $address;
        $a->port = null;
        $this->assertEquals('http://domain.ru/index.php?param=1#anchor', $a->abs());

        $a = clone $address;
        $a->path = null;
        $this->assertEquals('http://domain.ru:80/?param=1#anchor', $a->abs());

        $a = clone $address;
        $a->query = null;
        $this->assertEquals('http://domain.ru:80/index.php#anchor', $a->abs());

        $a = clone $address;
        $a->fragment = null;
        $this->assertEquals('http://domain.ru:80/index.php?param=1', $a->abs());
    }

    public function testScheme()
    {
        $a = new Address('');

        $a->scheme = 'http';        $this->assertEquals('http', $a->scheme);
        $a->scheme = [];            $this->assertEquals('http', $a->scheme);
        $a->scheme = true;          $this->assertEquals('http', $a->scheme);
        $a->scheme = '';            $this->assertNull($a->scheme);
        $a->scheme = 'http';
        $a->scheme = false;         $this->assertNull($a->scheme);
        $a->scheme = 'http';
        $a->scheme = null;          $this->assertNull($a->scheme);
        $a->scheme = 'http';
        $a->scheme = 0;             $this->assertNull($a->scheme);
    }

    public function testHost()
    {
        $a = new Address('');

        $a->host = 'http';          $this->assertEquals('http', $a->host);
        $a->host = [];              $this->assertEquals('http', $a->host);
        $a->host = true;            $this->assertEquals('http', $a->host);
        $a->host = '';              $this->assertNull($a->host);
        $a->host = 'http';
        $a->host = false;           $this->assertNull($a->host);
        $a->host = 'http';
        $a->host = null;            $this->assertNull($a->host);
        $a->host = 'http';
        $a->host = 0;               $this->assertNull($a->host);
    }

    public function testPort()
    {
        $a = new Address('');

        $a->port = 80;              $this->assertEquals(80, $a->port);
        $a->port = 'http';          $this->assertNull($a->port);
        $a->port = 80;
        $a->port = [];              $this->assertNull($a->port);
        $a->port = true;            $this->assertEquals(1, $a->port);
        $a->port = false;           $this->assertNull($a->port);
        $a->port = 80;
        $a->port = null;            $this->assertNull($a->port);
        $a->port = 80;
        $a->port = 0;               $this->assertNull($a->port);
    }

    public function testPath()
    {
        $a = new Address('');

        $a->path = 'http';          $this->assertEquals('http', $a->path);
        $a->path = [];              $this->assertEquals('http', $a->path);
        $a->path = true;            $this->assertEquals('http', $a->path);
        $a->path = '';              $this->assertNull($a->path);
        $a->path = 'http';
        $a->path = false;           $this->assertNull($a->path);
        $a->path = 'http';
        $a->path = null;            $this->assertNull($a->path);
        $a->path = 'http';
        $a->path = 0;               $this->assertNull($a->path);
    }

    public function testQuery()
    {
        $a = new Address('');
        $array = ['q' => 1];

        $a->query = $array;         $this->assertEquals($array, $a->query);
        $a->query = true;           $this->assertEquals($array, $a->query);
        $a->query = 'q=2';          $this->assertEquals($array, $a->query);
        $a->query = '';             $this->assertEquals([], $a->query);
        $a->query = $array;
        $a->query = false;          $this->assertEquals([], $a->query);
        $a->query = $array;
        $a->query = null;           $this->assertEquals([], $a->query);
        $a->query = $array;
        $a->query = 0;              $this->assertEquals([], $a->query);
    }

    public function testFragment()
    {
        $a = new Address('');

        $a->fragment = 'q';         $this->assertEquals('q', $a->fragment);
        $a->fragment = true;        $this->assertEquals('q', $a->fragment);
        $a->fragment = '';          $this->assertNull($a->fragment);
        $a->fragment = 'q';
        $a->fragment = false;       $this->assertNull($a->fragment);
        $a->fragment = 'q';
        $a->fragment = null;        $this->assertNull($a->fragment);
        $a->fragment = 'q';
        $a->fragment = 0;           $this->assertNull($a->fragment);
    }
}
