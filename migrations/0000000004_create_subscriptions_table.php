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
            ->addColumn('id_billing_record', 'biginteger')
            ->addColumn('billing_interval', 'enum', ['values' => ['day', 'week', 'month', 'year']])
            ->addColumn('billing_interval_count', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY])
            ->addColumn('billing_next_date', 'date', ['null' => true])
            ->addColumn('start_date', 'date', ['null' => true])
            ->addColumn('cancel_at', 'date', ['null' => true])
            ->addColumn('start_date', 'date', ['null' => true])
            ->addColumn('collection_method', 'string')
            ->addColumn('status', 'enum', ['values' => ['not_started', 'active', 'completed', 'canceled']])
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ]);

        $table->addIndex(['id_method']);
        $table->addIndex(['id_billing_record']);
        $table->addIndex(['id_token']);
        $table->addIndex(['date_start']);
        $table->addIndex(['date_end']);
        $table->addIndex(['status']);

        $table->save();
    }
}
