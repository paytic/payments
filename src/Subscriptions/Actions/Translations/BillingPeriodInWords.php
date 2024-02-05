<?php

namespace Paytic\Payments\Subscriptions\Actions\Translations;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;

class BillingPeriodInWords extends Action
{
    use HasSubject;

    protected $translator;

    /**
     * @param $translator
     */
    public function __construct()
    {
        $this->translator = translator();
    }

    public function handle()
    {
        if ($this->getSubject()->getBillingInterval() == 1) {
            return $this->handleOne();
        }
        return $this->handleMany();
    }

    protected function handleOne()
    {
        return $this->translate('billing_period.' . $this->getSubject()->getBillingPeriod() . '.one');
    }

    protected function translate(string $id, array $parameters = [], string $domain = null, string $locale = null)
    {
        return $this->translator->trans(
            'payments-subscriptions.labels.' . $id,
            $parameters, $domain, $locale
        );
    }

    protected function handleMany()
    {
        $item = $this->getSubject();
        return $this->translate(
            'interval.many',
            [
                'number' => $item->getBillingInterval(),
                'period' => $this->translate('billing_period.' . $item->getBillingPeriod() . '.many')
            ]
        );
    }
}