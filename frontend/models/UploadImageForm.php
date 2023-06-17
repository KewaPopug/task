<?php

namespace frontend\models;

use yii\base\Model;
class UploadImageForm extends Model {
    public $photo_url;
    public function rules() {
        return [
            [['photo_url'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, png'],
        ];
    }
    public function upload($model) {
        if ($this->validate()) {
            $basePath = "/var/www/task/frontend/web/";
            $path = 'uploads/' . $this->photo_url->baseName . '.' .
                $this->photo_url->extension;
            $this->photo_url->saveAs($basePath . $path);
//            $model->getUser()->photo_url = $path;
//            $model->getUser()->save();
//            return true;
            return $path;
        } else {
            return false;
        }
    }
}