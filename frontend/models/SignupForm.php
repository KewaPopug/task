<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    private $user;
    public $username;
    public $email;
    public $password;
    public $surname;
    public $firstname;
    public $patronymic;
    public $individual_identification_number;
    public $date_born;
    public $photo_url;

    private $path;

    public function __construct()
    {
        if($this->user == null) {
            $this->user = new User;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['profile.passwordMinLength']],

            [['surname', 'firstname', 'individual_identification_number', 'date_born'], 'required'],
            [['individual_identification_number'], 'integer',  'min' => 12, 'max' => 19],
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
    public function signup($model = null)
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user->username = $this->username;
        $this->user->email = $this->email;
        $this->user->setPassword($this->password);
        $this->user->generateAuthKey();
        $this->user->generateEmailVerificationToken();
        $this->user->surname = $this->surname;
        $this->user->firstname = $this->firstname;
        $this->user->patronymic = $this->patronymic;
        $this->user->individual_identification_number = $this->individual_identification_number;
        $this->user->date_born = $this->date_born;
        $this->user->photo_url = $this->user->upload($model);

        return $this->user->save();
//            && $this->sendEmail($this->user);
    }

    /**
     * Sends confirmation email to profile
     * @param User $user profile model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['profile' => $this->user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
//
//    public function upload()
//    {
//        if ($this->validate()) {
//            $this->path = 'uploads/' . $this->photo_url->baseName . '.' . $this->photo_url->extension;
//            $this->photo_url->saveAs($this->path);
//            return true;
//        } else {
//            return false;
//        }
//    }


    public function getUser()
    {
        return $this->user;
    }
}
