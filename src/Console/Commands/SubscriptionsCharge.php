<?php

namespace Paytic\Payments\Console\Commands;

use Bytic\Actions\Observers\Observers\ObserverConsoleOutput;
use ByTIC\Console\Command;
use Paytic\Payments\Subscriptions\Actions\ChargeSubscriptionsDue;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SessionsCleanup
 * @package Nip\Payments\Console\Commands
 */
class SubscriptionsCharge extends Command
{
    public const NAME = 'payments:subscriptions:charge';

    protected function configure()
    {
        parent::configure();
        $this->setName(static::NAME);
        $this
            ->setAliases(['p:charge'])
            ->setDescription('Charge due subscriptions');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $action = ChargeSubscriptionsDue::make();

        $observer = new ObserverConsoleOutput($output);
        $action->attach($observer);
        $action->handle();
        return 0;
    }
}
