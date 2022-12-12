<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

final class PaymentsLocationsTable extends AbstractMigration
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
        $table_locations = PaymentsModels::locations()->getTable();
        $exists = $this->hasTable($table_locations);
        if ($exists) {
            return;
        }
        $table_transactions = PaymentsModels::transactions()->getTable();

        $table = $this->table($table_locations)
            ->addColumn('tenant_id', 'integer', [])
            ->addColumn('tenant', 'string')
            ->addColumn('name', 'string')
            ->addColumn('address_line_1', 'string', ['null' => true])
            ->addColumn('address_city', 'string', ['null' => true])
            ->addColumn('address_country', 'string', ['limit' => '2', 'null' => true])
            ->addColumn('metadata', 'json', ['null' => true])
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ]);
        $table->addIndex(['tenant_id']);
        $table->addIndex(['tenant']);
        $table->save();

        $this->table($table_transactions)
            ->addColumn(
                'id_location',
                'integer',
                [
                    'null' => true,
                    'after' => 'id_subscription',
                ]
            )
            ->save();

        $this->table($table_transactions)
            ->addForeignKey(
                'id_location',
                $table_locations,
                'id',
                [
                    'constraint' => $table_transactions . '_id_location_' . $table_locations,
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION',
                ]
            )
            ->save();
    }
}
