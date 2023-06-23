<?php

namespace frontend\models;

use yii\base\Model;
class UploadImageForm extends Model {
    public $photo_url;
    public function rules() {
        return [
            [['photo_url'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'gif', 'jpeg']],
        ];
    }
    public function upload() {
        if ($this->validate()) {
            $basePath = "/var/www/task/frontend/web/";
            $path = 'uploads/' . $this->photo_url->baseName . '.' .
                $this->photo_url->extension;
            $this->photo_url->saveAs($basePath . $path);
            return $path;
        } else {
            return false;
        }
    }
}