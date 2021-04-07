<?php

use app\helpers\Migration;


/**
 * Class m210407_113526_initObjects
 */
class m210407_113526_initObjects extends Migration
{

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

        if ($this->checkTable(self::OBJECTS_TABLE)) {
            $this->createTable(self::OBJECTS_TABLE, [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'images' => $this->json(),
                'object_id'=> $this->integer()->notNull(),
//                'tasks_id' => $this->integer(), TODO::

                'created_at' => $this->integer()->notNull(),
                'created_by' => $this->integer()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->notNull(),
                'updated_by' => $this->integer()->notNull()->defaultValue(0),

            ], $tableOptions);

            //create index for column 'object_id'
            $this->createIndex(
                'idx-objects-object_id',
                self::OBJECTS_TABLE,
                'object_id'
            );

            //add foreign key for table 'objects'
            $this->addForeignKey(
                'fk-objects-object_id',
                self::OBJECTS_TABLE,
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
        if ($this->checkForeignKey(self::OBJECTS_TABLE, 'fk-objects-object_id')) {
            $this->dropForeignKey('fk-objects-object_id', self::OBJECTS_TABLE);
        }

        if ($this->checkUniqueIndexes(self::OBJECTS_TABLE, 'idx-objects-object_id')) {
            $this->dropIndex('idx-objects-object_id', self::OBJECTS_TABLE);
        }

        if (!$this->checkTable(self::OBJECTS_TABLE)) {
            $this->dropTable(self::OBJECTS_TABLE);
        }
    }


}
