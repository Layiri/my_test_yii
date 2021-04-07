<?php

use app\helpers\Migration;


/**
 * Class m210407_114120_initList_Task
 */
class m210407_114120_initList_Task extends Migration
{
    const LIST_TASKS_TABLE = '{{%list_tasks}}';
    const TASKS_TABLE = '{{%tasks}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        if ($this->checkTable(self::LIST_TASKS_TABLE)) {
            $this->createTable(self::LIST_TASKS_TABLE, [
                'id' => $this->primaryKey(),
                'task_id' => $this->integer()->notNull(),
                'name' => $this->string(),

                'created_at' => $this->integer()->notNull(),
                'created_by' => $this->integer()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->notNull(),
                'updated_by' => $this->integer()->notNull()->defaultValue(0),
            ], $tableOptions);

            //create index for column 'task_id'
            $this->createIndex(
                'idx-list_tasks-task_id',
                self::LIST_TASKS_TABLE,
                'task_id'
            );

            //add foreign key for table 'tasks'
            $this->addForeignKey(
                'fk-list_tasks-task_id',
                self::LIST_TASKS_TABLE,
                'task_id',
                self::TASKS_TABLE,
                'id',
                'RESTRICT',
                'CASCADE'
            );

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->checkForeignKey(self::LIST_TASKS_TABLE, 'fk-list_tasks-task_id')) {
            $this->dropForeignKey('fk-list_tasks-task_id', self::LIST_TASKS_TABLE);
        }

        if ($this->checkUniqueIndexes(self::LIST_TASKS_TABLE, 'idx-list_tasks-task_id')) {
            $this->dropIndex('idx-list_tasks-task_id', self::LIST_TASKS_TABLE);
        }

        if (!$this->checkTable(self::LIST_TASKS_TABLE)) {
            $this->dropTable(self::LIST_TASKS_TABLE);
        }

    }
}
