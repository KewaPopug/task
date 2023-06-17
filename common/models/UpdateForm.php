<?php

namespace common\models;

use Yii;

class UpdateForm extends \yii\base\Model
{
    private $user;
    public $id;
    public $username;
    public $email;
    public $surname;
    public $firstname;
    public $patronymic;
    public $individual_identification_number;
    public $date_born;
    public $photo_url;


    public function __construct($id)
    {
        if($this->user == null) {
            $this->user = User::find()->where(['id' => $id])->one();

            $this->id = $this->user->id;
            $this->username = $this->user->username;
            $this->email = $this->user->email;
            $this->surname = $this->user->surname;
            $this->firstname = $this->user->firstname;
            $this->patronymic = $this->user->patronymic;
            $this->individual_identification_number = $this->user->individual_identification_number;
            $this->date_born = $this->user->date_born;
            $this->photo_url = $this->user->photo_url;
        }
    }

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            [['surname', 'firstname', 'individual_identification_number', 'date_born'], 'required'],
            [['individual_identification_number'], 'integer'],
            [['date_born'], 'safe'],
            [['surname', 'firstname', 'patronymic'], 'string', 'max' => 255],
            ['photo_url', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
        ];
    }

    /**
     * Signs profile up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function update($user)
    {
        if (!$this->validate()) {

            return null;
        }

        $this->user->username = $this->username;
        $this->user->email = $this->email;
//        $this->user->setPassword($this->password);
//        $this->user->generateAuthKey();
        $this->user->generateEmailVerificationToken();
        $this->user->surname = $this->surname;
        $this->user->firstname = $this->firstname;
        $this->user->patronymic = $this->patronymic;
        $this->user->individual_identification_number = $this->individual_identification_number;
        $this->user->date_born = $this->date_born;
        $this->user->photo_url = $this->user->upload($user);


//        $user->username = $this->username;
//        $user->email = $this->email;
//        $user->setPassword($this->password);
//        $user->generateAuthKey();
//        $user->generateEmailVerificationToken();
//        $user->surname = $this->surname;
//        $user->firstname = $this->firstname;
//        $user->patronymic = $this->patronymic;
//        $user->individual_identification_number = $this->individual_identification_number;
//        $user->date_born = $this->date_born;
//        $user->photo_url = $this->upload($model);

        return $this->user->save();
    }
}