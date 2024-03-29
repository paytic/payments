<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

final class SubscriptionsTokensFK extends AbstractMigration
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
        $table_tokens = PaymentsModels::tokens()->getTable();

        $this->table($table_subscriptions)
            ->changeColumn(
                'id_token',
                'integer',
                [
                    'null' => true,
                ]
            )
            ->save();

        $this->table($table_subscriptions)
            ->addForeignKey(
                'id_token',
                $table_tokens,
                'id',
                [
                    'constraint' => $table_subscriptions . '_id_token_' . $table_tokens,
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION',
                ]
            )
            ->save();
    }
}
