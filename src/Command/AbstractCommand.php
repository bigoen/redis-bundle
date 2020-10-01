<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\Command;

use Predis\Client;
use Predis\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
abstract class AbstractCommand extends Command
{
    protected ParameterBagInterface $parameterBag;
    protected SymfonyStyle $io;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        parent::__construct(null);
        $this->parameterBag = $parameterBag;
    }

    protected function executeRedis(string $dsn, string $prefix, bool $isKey = false): int
    {
        // get keys.
        $client = $this->getClient($dsn);
        if (true === $isKey) {
            $keys = [$prefix];
        } else {
            $keys = $client->keys($prefix);
        }
        $num = count($keys);
        if (0 === $num) {
            $this->io->error("Keys not found!");

            return Command::FAILURE;
        }
        // delete keys.
        $client->del($keys);
        $this->io->success("Cache clear success it! Total clear: {$num}");

        return Command::SUCCESS;
    }

    protected function getClient(string $dsn): ?ClientInterface
    {
        return new Client($dsn);
    }
}
