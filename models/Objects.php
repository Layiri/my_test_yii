<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $images
 * @property int $object_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Objects $object
 * @property Objects[] $objects
 * @property TasksObjects[] $tasksObjects
 */
class Objects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['images'], 'safe'],
            [['object_id', 'created_at', 'updated_at'], 'required'],
            [['object_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['object_id' => 'id']],
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
            'images' => 'Images',
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
     * Gets query for [[Objects]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ObjectsQuery
     */
    public function getObjects()
    {
        return $this->hasMany(Objects::className(), ['object_id' => 'id']);
    }

    /**
     * Gets query for [[TasksObjects]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TasksObjectsQuery
     */
    public function getTasksObjects()
    {
        return $this->hasMany(TasksObjects::className(), ['object_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ObjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ObjectsQuery(get_called_class());
    }
}
