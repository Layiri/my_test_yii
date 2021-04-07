<?php

namespace app\helpers;

use Yii;

class Migration extends \yii\db\Migration
{
    protected function checkTable($tableName)
    {
        $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
        return ($tableSchema === null) ?  true : false;
    }

    protected function checkColumn($tableName, $columnName)
    {
        $columnExist = \Yii::$app->db->schema->getTableSchema($tableName)->getColumn($columnName);
        return ($columnExist === null) ?  true : false;
    }

    protected function addTable($table, $columns, $options = null)
    {
        if($this->checkTable($table))
        {
            $this->createTable($table, $columns, $options);
        }
    }

    protected function deleteTable($tableName)
    {
        if(!$this->checkTable($tableName))
        {
            $this->dropTable($tableName);
        }
    }

    protected function addCheckColumn($tableName, $columnName, $column)
    {
        if($this->checkColumn($tableName, $columnName))
        {
            $this->addColumn($tableName, $columnName, $column);
        }
    }

    protected function deleteColumn($tableName, $columnName)
    {
        if(!$this->checkColumn($tableName, $columnName))
        {
            $this->dropColumn($tableName, $columnName);
        }
    }

    protected function checkForeignKey($tableName, $nameKey)
    {
        if($this->checkTable($tableName)){
            return false;
        }

        $foreignKeys = \Yii::$app->db->schema->getTableSchema($tableName)->foreignKeys;
        return isset($foreignKeys[$nameKey]);
    }

    protected function checkUniqueIndexes($tableName, $nameKey)
    {
        if($this->checkTable($tableName)){
            return false;
        }

        $dbSchema = Yii::$app->db->schema;

        $myTableSchema = $dbSchema->getTableSchema($tableName);
        $uniqueIndexes = $dbSchema->findUniqueIndexes($myTableSchema);
        return isset($uniqueIndexes[$nameKey]);
    }

    protected function addIndex($table, $indexName, $column)
    {
        if(!$this->checkUniqueIndexes($table, $indexName))
        {
            $this->createIndex($indexName, $table, $column, true);
        }
    }

    protected function deleteIndex($table, $indexName)
    {
        if($this->checkUniqueIndexes($table, $indexName))
        {
            $this->dropIndex($indexName, $table);
        }
    }

    public function deleteForeignKey($name, $table)
    {
        if($this->checkForeignKey($table, $name))
        {
            $this->dropForeignKey($name, $table);
        }
    }

    public function dropTable($table, $ignoreEmpty = false)
    {
        if($ignoreEmpty){
            if(!$this->checkTable($table)){
                parent::dropTable($table);
            }
            else{
                echo "\n\rTable: ". $table ." does not exist!\n\r";
            }
        }
        else{
            parent::dropTable($table); // TODO: Change the autogenerated stub
        }
    }

    public function dropForeignKey($name, $table, $ignoreEmpty = false)
    {
        if($ignoreEmpty){
            if(!$this->checkTable($table)){
                if($this->checkForeignKey($table, $name)){
                    parent::dropForeignKey($name, $table); // TODO: Change the autogenerated stub
                }
                else{
                    echo "\n\rForeign key: ". $name ." does not exist!\n\r";
                }
            }
            else{
                echo "\n\rTable: ". $table ." does not exist!\n\r";
            }
        }
        else{
            parent::dropForeignKey($name, $table); // TODO: Change the autogenerated stub
        }
    }

    public function dropIndex($name, $table, $ignoreEmpty = false)
    {
        if($ignoreEmpty){
            if(!$this->checkTable($table)){
                try{
                    parent::dropIndex($name, $table); // TODO: Change the autogenerated stub
                }
                catch(\Exception $ex){
                    echo "\n\rIndex: ". $name ." does not exist!\n\r";
                }
            }
            else{
                echo "\n\rTable: ". $table ." does not exist!\n\r";
            }
        }
        else{
            parent::dropIndex($name, $table); // TODO: Change the autogenerated stub
        }
    }
}