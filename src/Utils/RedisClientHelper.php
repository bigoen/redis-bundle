<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\Utils;

use Redis;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
class RedisClientHelper
{
    const BASE_PARAMETER = "bigoen_redis.client.";
    // parameters.
    const DSN = "dsn";
    const KEY = "key";
    const PREFIX = "prefix";
    const NAMESPACE = "namespace";

    private ParameterBagInterface $parameterBag;
    private ?RedisHelper $redisHelper = null;
    private ?Redis $redis = null;

    private ?string $client = null;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getParameter(string $param, bool $isThrow = false)
    {
        $parameter = self::BASE_PARAMETER.$this->client.".".$param;
        if (false === $this->parameterBag->has($parameter)) {
            if (true === $isThrow) {
                throw new ParameterNotFoundException($parameter);
            } else {
                return null;
            }
        }

        return $this->parameterBag->get($parameter);
    }

    public function getRedisHelper(bool $isSetNamespace = false): RedisHelper
    {
        if (!$this->redisHelper instanceof RedisHelper) {
            $this->createRedisHelper($isSetNamespace);
        }

        return $this->redisHelper;
    }

    public function getRedis(): Redis
    {
        if (!$this->redis instanceof Redis) {
            $this->createRedis();
        }

        return $this->redis;
    }

    public function createRedisHelper(bool $isSetNamespace = false): RedisHelper
    {
        // create.
        $redisHelper = new RedisHelper($this->getParameter("dsn", true));
        if (true === $isSetNamespace) {
            // set namespace.
            $redisHelper->setNamespace($this->getParameter("namespace", true));
        }
        $this->redisHelper = $redisHelper;

        return $this->redisHelper;
    }

    public function createRedis(): Redis
    {
        $this->redis = $this->createRedisHelper()->getRedis();

        return $this->redis;
    }
}
