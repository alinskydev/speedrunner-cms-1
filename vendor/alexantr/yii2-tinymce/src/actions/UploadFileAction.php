<?php

namespace alexantr\tinymce\actions;

use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;


class UploadFileAction extends Action
{
    /**
     * @var string Path to directory where files will be uploaded.
     */
    public $path;

    /**
     * @var string URL path to directory where files will be uploaded.
     */
    public $url;

    /**
     * @var string Validator name
     */
    public $uploadOnlyImage = true;

    /**
     * @var string Variable's name that Imperavi Redactor sent upon image/file upload.
     */
    public $uploadParam = 'file';

    /**
     * @var bool Whether to replace the file with new one in case they have same name or not.
     */
    public $replace = false;

    /**
     * @var boolean If `true` unique filename will be generated automatically.
     */
    public $unique = true;

    /**
     * In case of `true` this option will be ignored if `$unique` will be also enabled.
     *
     * @var bool Whether to translit the uploaded file name or not.
     */
    public $translit = false;

    /**
     * @var array Model validator options.
     */
    public $validatorOptions = [];

    /**
     * @var string Model validator name.
     */
    private $_validator = 'image';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->url === null) {
            throw new InvalidConfigException('The "url" attribute must be set.');
        } else {
            $this->url = rtrim($this->url, '/') . '/';
        }
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" attribute must be set.');
        } else {
            $this->path = rtrim(Yii::getAlias($this->path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            if (!FileHelper::createDirectory($this->path)) {
                throw new InvalidCallException("Directory specified in 'path' attribute doesn't exist or cannot be created.");
            }
        }
        if ($this->uploadOnlyImage !== true) {
            $this->_validator = 'file';
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $model = new DynamicModel(['file' => $file]);
            $model->addRule('file', $this->_validator, $this->validatorOptions)->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file'),
                ];
            } else {
                if ($this->unique === true && $model->file->extension) {
                    $model->file->name = uniqid() . '.' . $model->file->extension;
                } elseif ($this->translit === true && $model->file->extension) {
                    $model->file->name = Inflector::slug($model->file->baseName) . '.' . $model->file->extension;
                }

                if (file_exists($this->path . $model->file->name) && $this->replace === false) {
                    return [
                        'error' => Yii::t('vova07/imperavi', 'ERROR_FILE_ALREADY_EXIST'),
                    ];
                }

                if ($model->file->saveAs($this->path . $model->file->name)) {
                    $result = ['id' => $model->file->name, 'location' => $this->url . $model->file->name];

                    if ($this->uploadOnlyImage !== true) {
                        $result['filename'] = $model->file->name;
                    }
                } else {
                    $result = [
                        'error' => Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE'),
                    ];
                }
            }

            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }
}
