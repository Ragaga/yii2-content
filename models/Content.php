<?php

namespace app\modules\content\models;

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
            [['header', 'text', 'code', 'url', 'tree_left', 'tree_right', 'level'], 'required'],
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
}
