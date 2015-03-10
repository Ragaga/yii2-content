<?php

namespace ragaga\yii2\content\models;

use app\extensions\HString;
use creocoder\nestedsets\NestedSetsBehavior;
use Faker\Provider\cs_CZ\DateTime;
use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $header
 * @property string $title
 * @property string $short_text
 * @property string $text
 * @property string $code
 * @property string $url
 * @property string $description
 * @property boolean $visible
 * @property integer $tree_left
 * @property integer $tree_right
 * @property integer $level
 * @property string $create_time
 * @property string $update_time
 */
class Content extends \yii\db\ActiveRecord
{

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
                 'leftAttribute' => 'tree_left',
                 'rightAttribute' => 'tree_right',
                 'depthAttribute' => 'level',
            ],
        ];
    }

    public static function find()
    {
        return new ContentQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header'], 'required'],
            [['code'], 'unique'],
            [['short_text', 'text', 'code', 'url', 'description'], 'string'],
            [['visible'], 'boolean'],
            [['tree_left', 'tree_right', 'level'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['header', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'header' => 'Header',
            'title' => 'Title',
            'short_text' => 'Short Text',
            'text' => 'Text',
            'code' => 'Code',
            'url' => 'Url',
            'description' => 'Description',
            'visible' => 'Visible',
            'tree_left' => 'Tree Left',
            'tree_right' => 'Tree Right',
            'level' => 'Level',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
    public function beforeValidate(){
        $module = Yii::$app->getModule('content');
        $this->code = $module->rus2trans($this->header);
        $this->short_text = $module->subString($this->text,$module->shortTextLength);
        return true;
    }

    public function beforeSave($insert){
        parent::beforeSave($insert);
        if(!$this->isRoot()){
            $parent = $this->parents(1)->one();
            $this->url = $parent->url."/".$this->code;
        }
        $time = new \DateTime();
        $time = $time->format('Y-m-d H:i:s');
        if($this->isNewRecord){
            $this->create_time = $time;
            $this->update_time = $time;
        }else{
            $this->update_time = $time;
        }
        return true;
    }

    public function getParent(){
        return $this->parents(1)->one();
    }
}
