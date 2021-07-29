<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Class TransactionsAmountField
 */
final class TransactionsAmountField extends AbstractMigration
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

        $this->table($table_name)
            ->changeColumn('amount', 'int', ['null' => true, 'before' => 'currency'])
            ->save();
    }
}
