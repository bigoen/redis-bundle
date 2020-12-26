<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\DependencyInjection;

use Bigoen\RedisBundle\Utils\RedisClientHelper;
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
        $container->setParameter(RedisClientHelper::BASE_PARAMETER.'.clients', array_keys($config['clients']));
        foreach ($config['clients'] as $name => $client) {
            if (isset($client['dsn'])) {
                $container->setParameter(RedisClientHelper::BASE_PARAMETER."{$name}.dsn", $client['dsn']);
            }
            if (isset($client['prefix'])) {
                $container->setParameter(RedisClientHelper::BASE_PARAMETER."{$name}.prefix", $client['prefix']);
            }
            if (isset($client['key'])) {
                $container->setParameter(RedisClientHelper::BASE_PARAMETER."{$name}.key", $client['key']);
            }
            if (isset($client['namespace'])) {
                $container->setParameter(RedisClientHelper::BASE_PARAMETER."{$name}.namespace", $client['namespace']);
            }
        }
    }
}
