<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class LogbookTable extends AbstractMigration
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
        $logbook = $this->table('logbooks');
        $logbook->addColumn('name', 'string', ['limit' => 250])
            ->addColumn('description', 'string', ['limit' => 250])
            ->addColumn('user_id', 'integer')
//            ->addColumn('workout_id', 'integer') This will be added on new release
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime', ['null' => true])
            ->create();
    }
}
