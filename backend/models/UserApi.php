<?php

namespace backend\models;

class UserApi extends \common\models\User
{
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.', 'when' => function($model) {
                return !isset($model->id);
            }],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['surname', 'firstname', 'individual_identification_number', 'date_born'], 'required'],
            [['individual_identification_number'], 'integer'],
            [['date_born'], 'safe'],
            [['surname', 'firstname', 'patronymic'], 'string', 'max' => 255],
            ['photo_url', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024 * 1024],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

//            ['auth_key', 'generateAuthKey'],
//            ['password_hash', 'genPasswordHash'],
//            ['verification_token', 'generateEmailVerificationToken']
        ];
    }

    public function fields()
    {
        return ['id', 'surname', 'firstname', 'patronymic', 'individual_identification_number', 'date_born', 'photo_url', 'email'];
    }

    public function extraFields()
    {
        return ['profile'];
    }
}