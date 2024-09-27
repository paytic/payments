<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

/**
 * Class CreateTokensTable.
 */
final class CreateTokensTable extends AbstractMigration
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
        $table_name = PaymentsModels::tokens()->getTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }

        $table = $this->table($table_name)
            ->addColumn('id_method', 'biginteger')
            ->addColumn('gateway', 'string')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('customer_type', 'string')
            ->addColumn('token_id', 'string')
            ->addColumn('expiration', 'timestamp')
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ]);

        $table->addIndex(['id_method']);
        $table->addIndex(['gateway']);
        $table->addIndex(['token_id']);
        $table->addIndex(['id_method', 'token_id'], ['unique' => true]);

        $table->save();
    }
}
