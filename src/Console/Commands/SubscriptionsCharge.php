<?php

namespace ByTIC\Payments\Console\Commands;

use ByTIC\Console\Command;
use ByTIC\Payments\Actions\Subscriptions\ChargeSubscription;
use ByTIC\Payments\Utility\PaymentsModels;
use Enqueue\Consumption\ChainExtension;
use Enqueue\Consumption\Extension\ExitStatusExtension;
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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = PaymentsModels::subscriptions();

        $repository->findChargeDue(10)->each(function ($subscription) {
            ChargeSubscription::handle($subscription);
        });
        return 0;
    }
}
