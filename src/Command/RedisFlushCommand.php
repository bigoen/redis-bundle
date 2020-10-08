<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\Command;

use Bigoen\RedisBundle\Utils\RedisClientHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
class RedisFlushCommand extends Command
{
    private RedisClientHelper $clientHelper;

    public function __construct(RedisClientHelper $clientHelper)
    {
        parent::__construct(null);
        $this->clientHelper = $clientHelper;
    }

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

            return Command::SUCCESS;
        }
        $client = $this->clientHelper->setClient($input->getArgument('client'))->createRedis();
        $prefix = $this->clientHelper->getParameter('prefix');
        $key = $this->clientHelper->getParameter('key');
        // check parameters.
        if (is_null($prefix) && is_null($key)) {
            $this->io->error("Parameters not found!");

            return Command::SUCCESS;
        }

        if (is_string($key)) {
            $keys = [$key];
        } else {
            $keys = $client->keys($prefix);
        }
        $num = count($keys);
        if (0 === $num) {
            $this->io->error("Keys not found!");

            return Command::SUCCESS;
        }
        // delete keys.
        $client->del($keys);
        $this->io->success("Cache clear success it! Total clear: {$num}");

        return Command::SUCCESS;
    }
}
