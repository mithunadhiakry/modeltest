<?php

namespace backend\models;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\UploadedFile; 
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * This is the model class for table "ad_management".
 *
 * @property integer $id
 * @property string $ad_name
 * @property string $ad_identifier
 * @property string $ad_description
 * @property integer $status
 * @property string $time
 */
class AdManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_name', 'ad_identifier', 'status','url'], 'required'],
            [['ad_description'], 'string'],
            [['status'], 'integer'],
            [['time','image'], 'safe'],
            [['ad_name', 'ad_identifier'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ad_name' => 'Name',
            'ad_identifier' => 'Identifier',
            'ad_description' => 'Description',
            'status' => 'Status',
            'time' => 'Time',
            'url' => 'Link',
            'image' => 'Image'
        ];
    }
}
