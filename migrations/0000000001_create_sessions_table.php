<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

/**
 * Class OrgReportsFileStatus.
 */
final class CreateSessionsTable extends AbstractMigration
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
        $table_name = PaymentsModels::sessions()->getTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }

        $table = $this->table($table_name);
        $table->addColumn('id_purchase', 'biginteger');
        $table->addColumn('gateway', 'string');
        $table->addColumn('type', 'string');
        $table->addColumn('new_status', 'string');
        $table->addColumn('post', 'text');
        $table->addColumn('get', 'text');
        $table->addColumn('debug', 'text');
        $table->addColumn('created', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addIndex(['id_purchase']);
        $table->addIndex(['gateway']);
        $table->addIndex(['type']);

        $table->save();
    }
}
