<?php

namespace ByTIC\Payments\Console\Commands;

use ByTIC\Console\Command;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionsTrait;
use ByTIC\Payments\Utility\PaymentsModels;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SessionsCleanup
 * @package Nip\Payments\Console\Commands
 */
class SessionsCleanup extends Command
{
    public const NAME = 'payments:sessions:cleanup';

    protected function configure()
    {
        parent::configure();
        $this->setName(static::NAME);

        $this
            ->setAliases(['p:cleanup'])
            ->setDescription('Cleanup old payment sessions');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->handle();
        $output->writeln(
            "Cleanup [{$result}] sessions"
        );
        return 0;
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        /** @var PurchaseSessionsTrait $manager */
        $manager = PaymentsModels::sessions();
        $result = $manager->reduceOldSessions();
        $rows = $result->numRows();
        return is_int($rows) ? $rows : 0;
    }
}
