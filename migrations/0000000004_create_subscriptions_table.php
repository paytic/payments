<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateTokensTable
 */
final class CreateSubscriptionsTable extends AbstractMigration
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
        $table_name = \ByTIC\Payments\Utility\PaymentsModels::subscriptions()->getTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }

        $table = $this->table($table_name)
            ->addColumn('id_method', 'biginteger')
            ->addColumn('id_token', 'biginteger')
            ->addColumn('id_last_transaction', 'biginteger')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('customer_type', 'string')
            ->addColumn('status', 'enum', ['values' => ['not_started', 'active', 'completed', 'canceled']])
            ->addColumn('billing_period', 'enum', ['values' => ['daily', 'weekly', 'monthly', 'yearly']])
            ->addColumn('billing_interval', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY])
            ->addColumn('billing_count', 'integer', ['null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY])
            ->addColumn('start_at', 'date', ['null' => true])
            ->addColumn('cancel_at', 'date', ['null' => true])
            ->addColumn('ended_at', 'date', ['null' => true])
            ->addColumn('charge_at', 'date', ['null' => true])
            ->addColumn('charge_attempts', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY])
            ->addColumn('charge_count', 'integer', ['null' => true,'limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY])
            ->addColumn('charge_method', 'string')
            ->addColumn('metadata', 'json')
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ]);

        $table->addIndex(['id_method']);
        $table->addIndex(['id_token']);
        $table->addIndex(['id_last_transaction']);
        $table->addIndex(['customer_id','customer_type']);
        $table->addIndex(['status']);
        $table->addIndex(['start_at']);
        $table->addIndex(['cancel_at']);
        $table->addIndex(['ended_at']);
        $table->addIndex(['charge_at']);

        $table->save();
    }
}
