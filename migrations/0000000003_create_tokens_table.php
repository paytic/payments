<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateTokensTable
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
        $table_name = \ByTIC\Payments\Utility\PaymentsModels::transactions()->getTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }

        $table = $this->table($table_name)
            ->addColumn('id_purchase', 'biginteger')
            ->addColumn('gateway', 'string')
            ->addColumn('currency', 'string', ['limit' => '3'])

            ->addColumn('card', 'string')
            ->addColumn('code', 'string')
            ->addColumn('reference', 'string')
            ->addColumn('metadata', 'json')
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ]);

        $table->addIndex(['id_purchase']);
        $table->addIndex(['currency']);
        $table->addIndex(['type']);

        $table->save();
    }
}
