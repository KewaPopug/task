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
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['surname', 'firstname', 'individual_identification_number', 'date_born'], 'required'],
            [['individual_identification_number'], 'integer'],
            [['date_born'], 'safe'],
            [['surname', 'firstname', 'patronymic'], 'string', 'max' => 255],
            ['photo_url', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->surname = $this->surname;
        $user->firstname = $this->firstname;
        $user->patronymic = $this->patronymic;
        $user->individual_identification_number = $this->individual_identification_number;
        $user->date_born = $this->date_born;
        $user->photo_url = $this->photo_url;
//        var_dump($user->photo_url );
//        die();


        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    public function upload()
    {
        if ($this->validate()) {
//            var_dump(123123);
//            die();
            $this->path = 'uploads/' . $this->photo_url->baseName . '.' . $this->photo_url->extension;
            $this->photo_url->saveAs($this->path);
            return true;
        } else {
            return false;
        }
    }
}
