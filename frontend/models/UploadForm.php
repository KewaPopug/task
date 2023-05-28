<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $photo_url;
    public $path;

    public function rules()
    {
        return [
            ['photo_url', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->path = 'uploads/' . $this->photo_url->baseName . '.' . $this->photo_url->extension;
            $this->photo_url->saveAs($this->path);
            return true;
        } else {
            return false;
        }
    }
}