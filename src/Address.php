<?php

namespace veejay\address;

/**
 * Class Address
 * @package veejay\address
 *
 * @property string|null $scheme
 * @property string|null $host
 * @property int|null $port
 * @property string|null $path
 * @property array $query
 * @property string|null $fragment
 */
class Address
{
    /**
     * http://domain.ru:80/index.php?param=1#anchor - http
     * @var string|null
     */
    protected $scheme;

    /**
     * http://domain.ru:80/index.php?param=1#anchor - domain.ru
     * @var string|null
     */
    protected $host;

    /**
     * http://domain.ru:80/index.php?param=1#anchor - 80
     * @var int|null
     */
    protected $port;

    /**
     * http://domain.ru:80/index.php?param=1#anchor - /index.php
     * @var string|null
     */
    protected $path;

    /**
     * http://domain.ru:80/index.php?param=1#anchor - [param => 1]
     * @var array
     */
    protected $query = [];

    /**
     * http://domain.ru:80/index.php?param=1#anchor - anchor
     * @var string|null
     */
    protected $fragment;

    /**
     * @param string $url - address than can be parsed by function parse_url()
     */
    public function __construct(string $url)
    {
        $parts = parse_url($url);
        foreach ($parts as $key => $value) {
            if ($key == 'query') {
                parse_str($value, $value);
            }
            $this->__set($key, $value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($name == 'port') {
            $this->setPort($value);
        } elseif ($name == 'query') {
            $this->setQuery($value);
        } elseif (property_exists($this, $name)) {
            if (is_null($value) || $value == '') {
                $this->$name = null;
            } elseif (is_string($value)) {
                $this->$name = $value;
            }
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Generate relative url.
     * @return string
     */
    public function rel(): string
    {
        $str = '';
        if ($this->path !== null) {
            $str .= $this->path;
        }
        if (!empty($this->query)) {
            $str .= '?' . http_build_query($this->query, '', '&');
        }
        if ($this->fragment !== null) {
            $str .= '#' . $this->fragment;
        }
        if (substr($str, 0, 1) != '/') {
            $str = '/' . $str;
        }
        return $str;
    }

    /**
     * Generate absolute url.
     * @return string
     */
    public function abs(): string
    {
        $str = '';
        if ($this->scheme !== null) {
            $str .= $this->scheme . '://';
        }
        if ($this->host !== null) {
            $str .= $this->host;
        }
        if ($this->port !== null) {
            $str .= ':' . $this->port;
        }
        if (!$this->absAllowed()) {
            $str = '';
        }
        $str .= $this->rel();
        return $str;
    }

    /**
     * Is absolute url allowed.
     * @return bool
     */
    public function absAllowed(): bool
    {
        return $this->scheme !== null && $this->host !== null;
    }

    /**
     * Set port value.
     * @param mixed $value
     * @return void
     */
    protected function setPort($value)
    {
        settype($value, 'int');
        $this->port = empty($value) ? null : $value;
    }

    /**
     * Set query value.
     * @param mixed $value
     * @return void
     */
    protected function setQuery($value)
    {
        if (empty($value)) {
            $this->query = [];
        } elseif (is_array($value)) {
            $this->query = $value;
        }
    }
}
