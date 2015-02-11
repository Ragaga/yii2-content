<?php

namespace app\modules\content;

use yii\base\InvalidConfigException;

class Content extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\content\controllers';

    /**
     * @var string $image_dir - Папка для хранения картинок
     */
    public $imageDir;

    /**
     * @var array Model classes, e.g., ["Content" => "ragnarek\models\Content"]
     * Usage:
     *   $user = Yii::$app->getModule("content")->model("Content", $config);
     *   (equivalent to)
     *   $user = new ragnarek\models\Content($config);
     *
     * The model classes here will be merged with/override the [[getDefaultModelClasses()|default ones]]
     */
    public $modelClasses;

    public function init()
    {
        parent::init();
        $this->checkModuleProperties();
        $this->modelClasses = array_merge($this->getDefaultModelClasses(), $this->modelClasses);
        // custom initialization code goes here
    }

    /**
     * Check for valid module properties
     */
    protected function checkModuleProperties()
    {
        $className = get_called_class();
        if(!$this->imageDir){
            throw new InvalidConfigException("{$className}: \$image_dir must be defined");
        }
        $this->imageDir = \Yii::getAlias($this->imageDir);

        if(!file_exists($this->imageDir)){
            throw new InvalidConfigException("{$className}: Directory {$this->imageDir} is not exist");
        }

        if(is_writable($this->imageDir)){
            throw new InvalidConfigException("{$className}: Directory {$this->imageDir} must be writable");
        }
    }

    /**
     * Get object instance of model
     *
     * @param string $name
     * @param array  $config
     * @return ActiveRecord
     */
    public function model($name, $config = [])
    {
        // return object if already created
        if (!empty($this->_models[$name])) {
            return $this->_models[$name];
        }
        // create model and return it
        $className = $this->modelClasses[ucfirst($name)];
        $this->_models[$name] = Yii::createObject(array_merge(["class" => $className], $config));
        return $this->_models[$name];
    }

    /**
     * Get default model classes
     */
    protected function getDefaultModelClasses()
    {
        // use single quotes so nothing gets escaped
        return [
            'Content'       => 'ragnarek\models\Content',
        ];
    }
}
