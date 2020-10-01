<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
class RedisFlushCommand extends AbstractCommand
{
    protected static $defaultName = 'redis:flush';

    protected function configure(): void
    {
        $this
            ->setDescription('Flush redis client.')
            ->addArgument('client', InputArgument::REQUIRED, 'Flush client name.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        // check option.
        if (!$input->hasArgument('client')) {
            $this->io->error("Flush client name required!");

            return Command::FAILURE;
        }
        $option = $input->getArgument('client');
        $dsn = "bigoen_redis.client.{$option}.dsn";
        $prefix = "bigoen_redis.client.{$option}.prefix";
        $key = "bigoen_redis.client.{$option}.key";
        // check parameters.
        $hasDsn = $this->parameterBag->has($dsn);
        $hasPrefix = $this->parameterBag->has($prefix);
        $hasKey = $this->parameterBag->has($key);
        if (!$hasDsn || (!$hasPrefix && !$hasKey)) {
            $this->io->error("Parameters not found!");

            return Command::FAILURE;
        }

        return $this->executeRedis(
            $this->parameterBag->get($dsn),
            $hasKey ? $this->parameterBag->get($key) : $this->parameterBag->get($prefix),
            $hasKey
        );
    }
}
