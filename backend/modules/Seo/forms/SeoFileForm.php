<?php

namespace backend\modules\Seo\forms;

use Yii;
use speedrunner\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\modules\User\models\User;


class SeoFileForm extends Model
{
    public static $files_url;
    
    public $robots;
    public $sitemap;
    
    public function init()
    {
        static::$files_url = [
            'robots' => Yii::getAlias('@frontend/web/robots.txt'),
            'sitemap' => Yii::getAlias('@frontend/web/sitemap.xml'),
        ];
        
        $this->robots = file_exists(static::$files_url['robots']) ? file_get_contents(static::$files_url['robots']) : null;
    }
    
    public function prepareRules()
    {
        return [
            'robots' => [
                ['string'],
            ],
            'sitemap' => [
                ['file', 'extensions' => ['xml'], 'maxSize' => 1024 * 1024 * 100],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'robots' => 'Robots.txt',
            'sitemap' => 'Sitemap.xml',
        ];
    }
    
    public function beforeValidate()
    {
        $this->robots = htmlspecialchars($this->robots, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        
        if ($sitemap = UploadedFile::getInstance($this, 'sitemap')) {
            $this->sitemap = $sitemap;
        }
        
        return parent::beforeValidate();
    }
    
    public function update()
    {
        file_put_contents(static::$files_url['robots'], $this->robots);
        
        if ($this->sitemap instanceof UploadedFile) {
            $this->sitemap->saveAs(static::$files_url['sitemap']);
        }
        
        return true;
    }
}
