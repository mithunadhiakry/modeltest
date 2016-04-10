<?php
namespace backend\models;

use yii\base\Model;
use Yii;

class Copyqueston extends Model
{
    public $from_country;
    public $from_category;
    public $from_subcategory;
    public $from_subject;
    public $from_chapter;

    public $to_country;
    public $to_category;
    public $to_subcategory;
    public $to_subject;
    public $to_chapter;

    
    public function rules()
    {
        return [
            [['from_country','from_category','from_subcategory','from_subject','from_chapter','to_country','to_category','to_subcategory','to_subject','to_chapter'], 'required'],
        ];
    }


}
