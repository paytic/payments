<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

/**
 * Class CreateTokensTable.
 */
final class SubscriptionsChargeTimestamp extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table_name = PaymentsModels::subscriptions()->getTable();

        $this->table($table_name)
            ->changeColumn('charge_at', 'datetime', ['null' => true])
            ->save();
    }
}
