<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $name
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property ListsTasks[] $listTasks
 * @property TasksObjects[] $tasksObjects
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[ListTasks]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ListsTasksQuery
     */
    public function getListTasks()
    {
        return $this->hasMany(ListsTasks::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksObjects]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TasksObjectsQuery
     */
    public function getTasksObjects()
    {
        return $this->hasMany(TasksObjects::className(), ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TasksQuery(get_called_class());
    }
}
