<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;
use Phinx\Migration\AbstractMigration;

final class MethodsTypeChange extends AbstractMigration
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
        $repository = PaymentsModels::methods();
        $table = $repository->getTable();

        $types = $repository->getTypes();
        $values = [];
        foreach ($types as $type) {
            $values[] = $type->getName();
            $this->query(
                'UPDATE `' . $table . '`
                    SET `type` = "' . $type->getName() . '"
                    WHERE `type` IN ("' . implode('","', $type->getAliases()) . '")
                    '
            );
        }
        $this->query(
            'UPDATE `' . $table . '`
                    SET `type` = "bank_transfer"
                    WHERE `type` = ""
                    '
        );


        $this->table($table)
            ->changeColumn(
                'type',
                'enum',
                ['values' => $values, 'null' => false, 'default' => 'bank_transfer']
            )
            ->save();


    }
}
