<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AccountTableMigration extends AbstractMigration
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
        $account = $this->table('account');
        $account->addColumn('username', 'string', ['limit' => 250])
            ->addColumn('password', 'string', ['limit' => 250])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime', ['null' => true])
            ->addIndex('username', ['unique' => true])
            ->create();
    }
}
