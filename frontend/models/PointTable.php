<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "point_table".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $points
 */
class PointTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'point_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'identifier', 'points'], 'required'],
            [['points'], 'integer'],
            [['name', 'identifier'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'identifier' => 'Identifier',
            'points' => 'Points',
        ];
    }
}
