<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

/**
 * Class OrgReportsFileStatus.
 */
final class CreateMethodLinksTable extends AbstractMigration
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
        $table_name = PaymentsModels::methodLinks()->getTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }

        $table = $this->table($table_name);
        $table
            ->addColumn('id_method', 'biginteger')
            ->addColumn('tenant_id', 'integer', [])
            ->addColumn('tenant', 'string')
            ->addColumn('visible', 'enum', ['values' => ['yes', 'no'], 'default' => 'yes'])
            ->addColumn('primary', 'enum', ['values' => ['yes', 'no'], 'default' => 'no'])
            ->addColumn('notes', 'text');

        $table->addIndex(['tenant_id']);
        $table->addIndex(['tenant']);
        $table->addIndex(['id_method']);
        $table->addIndex(
            ['tenant', 'tenant_id', 'id_method'],
            ['unique' => true, 'name' => 'unique_method_tenant']
        );

        $table->save();
    }
}
