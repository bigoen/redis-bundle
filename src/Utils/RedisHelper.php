<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\Utils;

use Redis;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
class RedisHelper
{
    protected string $dsn;
    protected string $namespace;
    protected array $options = [
        'class' => Redis::class,
    ];

    protected ?Redis $redis = null;

    public function __construct(string $dsn)
    {
        $this->dsn = $dsn;
    }

    public function addNamespace(string $namespace): self
    {
        $this->namespace .= ":$namespace";

        return $this;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function connect(): self
    {
        $this->redis = RedisAdapter::createConnection($this->dsn, $this->options);

        return $this;
    }

    public function getRedis(): Redis
    {
        if (!$this->redis instanceof Redis) {
            $this->connect();
        }

        return $this->redis;
    }

    public function createRedisAdapter(): RedisAdapter
    {
        return new RedisAdapter($this->getRedis(), $this->namespace);
    }

    public function createPsr16Cache(): Psr16Cache
    {
        return new Psr16Cache($this->createRedisAdapter());
    }
}
