<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
class BigoenRedisExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        if (!isset($config['clients']) || 0 === count($config['clients'])) {
            return;
        }
        foreach ($config['clients'] as $name => $client) {
            if (isset($client['dsn'])) {
                $container->setParameter("bigoen_redis.client.{$name}.dsn", $client['dsn']);
            }
            if (isset($client['prefix'])) {
                $container->setParameter("bigoen_redis.client.{$name}.prefix", $client['prefix']);
            }
            if (isset($client['key'])) {
                $container->setParameter("bigoen_redis.client.{$name}.key", $client['key']);
            }
        }
    }
}
