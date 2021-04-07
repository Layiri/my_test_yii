<?php

use app\helpers\Migration;


/**
 * Class m210407_114327_init_task_object
 */
class m210407_114327_init_task_object extends Migration
{

    const TASKS_OBJECTS_TABLE = '{{%tasks_objects}}';
    const TASKS_TABLE = '{{%tasks}}';
    const OBJECTS_TABLE = '{{%objects}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        if ($this->checkTable(self::TASKS_OBJECTS_TABLE)) {
            $this->createTable(self::TASKS_OBJECTS_TABLE, [
                'id' => $this->primaryKey(),
                'task_id' => $this->integer()->notNull(),
                'object_id' => $this->integer()->notNull(),

                'created_at' => $this->integer()->notNull(),
                'created_by' => $this->integer()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->notNull(),
                'updated_by' => $this->integer()->notNull()->defaultValue(0),
            ], $tableOptions);

            //create index for column 'task_id'
            $this->createIndex(
                'idx-tasks_objects-task_id',
                self::TASKS_OBJECTS_TABLE,
                'task_id'
            );

            //create index for column 'object_id'
            $this->createIndex(
                'idx-tasks_objects-object_id',
                self::TASKS_OBJECTS_TABLE,
                'object_id'
            );

            //add foreign key for table 'tasks'
            $this->addForeignKey(
                'fk-tasks_objects-task_id',
                self::TASKS_OBJECTS_TABLE,
                'task_id',
                self::TASKS_TABLE,
                'id',
                'RESTRICT',
                'CASCADE'
            );


            //add foreign key for table 'object_id'
            $this->addForeignKey(
                'fk-tasks_objects-object_id',
                self::TASKS_OBJECTS_TABLE,
                'object_id',
                self::OBJECTS_TABLE,
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
        if ($this->checkForeignKey(self::TASKS_OBJECTS_TABLE, 'fk-tasks_objects-task_id')) {
            $this->dropForeignKey('fk-tasks_objects-task_id', self::TASKS_OBJECTS_TABLE);
        }

        if ($this->checkForeignKey(self::TASKS_OBJECTS_TABLE, 'fk-tasks_objects-object_id')) {
            $this->dropForeignKey('fk-tasks_objects-object_id', self::TASKS_OBJECTS_TABLE);
        }

        if ($this->checkUniqueIndexes(self::TASKS_OBJECTS_TABLE, 'idx-tasks_objects-task_id')) {
            $this->dropIndex('idx-tasks_objects-task_id', self::TASKS_OBJECTS_TABLE);
        }

        if ($this->checkUniqueIndexes(self::TASKS_OBJECTS_TABLE, 'idx-tasks_objects-object_id')) {
            $this->dropIndex('idx-tasks_objects-object_id', self::TASKS_OBJECTS_TABLE);
        }

        if (!$this->checkTable(self::TASKS_OBJECTS_TABLE)) {
            $this->dropTable(self::TASKS_OBJECTS_TABLE);
        }
    }


}
