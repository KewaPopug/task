<?php

namespace common\models;

use frontend\models\UploadImageForm;
use frontend\models\UserRefreshTokens;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use function PHPUnit\Framework\stringContains;


/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string $surname
 * @property string $firstname
 * @property string|null $patronymic
 * @property int $individual_identification_number
 * @property string $date_born
 * @property string $photo_url
 */
class User extends \mdm\admin\models\User
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    private $user;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            ['username', 'trim'],
//            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
//            ['username', 'string', 'min' => 2, 'max' => 255],
//
//            ['email', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
////            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
//
//            [['surname', 'firstname', 'individual_identification_number', 'date_born'], 'required'],
//            [['individual_identification_number'], 'integer'],
//            [['date_born'], 'safe'],
//            [['surname', 'firstname', 'patronymic'], 'string', 'max' => 255],
//            ['photo_url', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024 * 1024],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::find()
            ->where(['id' => (string) $token->getClaim('uid') ])
//            ->andWhere(['<>', 'usr_status', 'inactive'])  //adapt this to your needs
            ->one();
    }


    public static function validationJwt($token){

        $data = Yii::$app->jwt->getValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer('http://sijaksa.dev');
        $data->setAudience('http://sijaksa.dev');
        $data->setId('4f1g23a12aa');

        if($token->validate($data)){
            return static::findOne(['id' => $token->getClaim('uid'), 'status' => self::STATUS_ACTIVE]);
        }

        return null;
    }

    public static function generateToken($id){
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();
        $token = $jwt->getBuilder()
            ->issuedBy('http://sijaksa.dev')// Configures the issuer (iss claim)
            ->permittedFor('http://sijaksa.dev')// Configures the audience (aud claim)
            ->identifiedBy('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
            ->issuedAt($time)// Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 60)// Configures the expiration time of the token (exp claim)
            //3600 = 60 menit = 1 jam
            ->withClaim('uid', $id)// Configures a new claim, called "uid"
            ->getToken($signer, $key); // Retrieves the generated token

        return (string)$token;
    }


    /**
     * Finds profile by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds profile by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds profile by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['profile.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param mixed $photo_url
     */
    public function setPhotoUrl($photo_url): void
    {
        $this->photo_url = $photo_url;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current profile
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function activate($model)
    {
        $model->status = 10;
        $model->save();
    }

    public function banned($model)
    {
        $model->status = 9;
        $model->save();
    }


    public function upload($model = null)
    {
        if ($model != null) {
            $modelUpload = new UploadImageForm();
            $modelUpload->photo_url = UploadedFile::getInstance($model, 'photo_url');

            return $modelUpload->upload();
        }

        return false; // фото по умолчанию
    }

    public function genPasswordHash()
    {
        $this->password_hash = Yii::$app->security->generateRandomString();
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),  3600);
        }

        return false;
    }


    /**
     * Finds profile by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

    public function afterSave($isInsert, $changedOldAttributes) {
        // Purge the user tokens when the password is changed
        if (array_key_exists('usr_password', $changedOldAttributes)) {
            UserRefreshTokens::deleteAll(['urf_userID' => $this->userID]);
        }

        return parent::afterSave($isInsert, $changedOldAttributes);
    }
}