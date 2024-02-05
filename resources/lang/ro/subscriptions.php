<?php

use Paytic\CommonObjects\Subscription\Billing\BillingPeriod;

return [
    'payments-subscriptions.labels.title' => 'Abonamente',
    'payments-subscriptions.labels.title.singular' => 'Abonament',
    'payments-subscriptions.labels.reports' => 'Rapoarte abonamente',

    'payments-subscriptions.labels.recurring' => 'Recurenţă',
    'payments-subscriptions.labels.interval' => 'Interval',
    'payments-subscriptions.labels.interval.many' => 'O dată la #{number} #{period}',
    'payments-subscriptions.labels.status' => 'Status',

    'payments-subscriptions.labels.btn.edit' => 'Editează recurenţa',
    'payments-subscriptions.labels.btn.cancel' => 'Anulează recurenţa',

    'payments-subscriptions.labels.billing_period.' . BillingPeriod::DAILY . '.one' => 'Zilnic',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::DAILY . '.many' => 'zile',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::WEEKLY . '.one' => 'Săptămânal',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::WEEKLY . '.many' => 'săptămâni',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::MONTHLY . '.one' => 'Lunar',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::MONTHLY . '.many' => 'luni',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::YEARLY . '.one' => 'Anual',
    'payments-subscriptions.labels.billing_period.' . BillingPeriod::YEARLY . '.many' => 'ani',

    'payments-subscriptions.statuses.pending' => 'Neconfirmat',
    'payments-subscriptions.statuses.active' => 'Activ',
    'payments-subscriptions.statuses.canceled' => 'Anulat',
    'payments-subscriptions.statuses.deactivated' => 'Dezactivat',
    'payments-subscriptions.statuses.paused' => 'Pauză',
    'payments-subscriptions.statuses.pastdue' => 'Plată restantă',
    'payments-subscriptions.statuses.unpaid' => 'Neplătit',

    'payments-subscriptions.messages.dunning.next_charge' => 'Următoarea tranzacţie de <strong>#{amount}</strong> se va efectua pe <strong>#{next}</strong>.',
    'payments-subscriptions.messages.canceled' => 'Recurenţa a fost anulată cu succes.',
    'payments-subscriptions.messages.reactivate' => 'Recurenţa a fost reactivată cu succes.',
];
