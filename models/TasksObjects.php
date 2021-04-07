<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks_objects".
 *
 * @property int $id
 * @property int $task_id
 * @property int $object_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Object $object
 * @property Tasks $task
 */
class TasksObjects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'object_id', 'created_at', 'updated_at'], 'required'],
            [['task_id', 'object_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['object_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'object_id' => 'Object ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Object]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ObjectsQuery
     */
    public function getObject()
    {
        return $this->hasOne(Objects::className(), ['id' => 'object_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TasksQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\TasksObjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TasksObjectsQuery(get_called_class());
    }
}