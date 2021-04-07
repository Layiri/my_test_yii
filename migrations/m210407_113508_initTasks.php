<?php

use app\helpers\Migration;


/**
 * Class m210407_113508_initTasks
 */
class m210407_113508_initTasks extends Migration
{
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

        if ($this->checkTable(self::TASKS_TABLE)) {
            $this->createTable(self::TASKS_TABLE, [
                'id' => $this->primaryKey(),
                'name' => $this->string(),

                'created_at' => $this->integer()->notNull(),
                'created_by' => $this->integer()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->notNull(),
                'updated_by' => $this->integer()->notNull()->defaultValue(0),

            ], $tableOptions);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (!$this->checkTable(self::TASKS_TABLE)) {
            $this->dropTable(self::TASKS_TABLE);
        }
    }

}
