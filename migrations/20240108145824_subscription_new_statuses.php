<?php
declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

final class SubscriptionNewStatuses extends AbstractMigration
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
        $table_subscriptions = PaymentsModels::subscriptions()->getTable();
        $table = $this->table($table_subscriptions);

        $this->table($table_subscriptions)
            ->changeColumn(
                'status',
                'enum',
                [
                    'values' => ['pending', 'active', 'canceled', 'deactivated', 'paused', 'pastdue', 'unpaid'],
                    'default' => 'pending',
                    'null' => true,
                ]
            )
            ->save();
    }
}
