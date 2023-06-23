<?php

namespace frontend\controllers;

use common\models\UpdateForm;
use common\models\User;
use frontend\models\SignupForm;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;

class ApiController extends \yii\rest\Controller
{
    public $enableCsrfValidation = false;
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'registration',
                'refresh-token',
                'options',
            ],
        ];

        return $behaviors;
    }

    public function actionRegistration()
    {
        $request = Yii::$app->getRequest();
        $userData = $request->getBodyParams();

        $user = new User();
        $user->attributes = $userData;

        $signupForm = new SignupForm();
        $signupForm->load($userData, '');

        return $signupForm->signup($user);
    }

    public function actionCurrentUpdate()
    {
        $request = Yii::$app->getRequest();
        $userData = $request->getBodyParams();

        $user = User::findOne(Yii::$app->user->id);
        $user->attributes = $userData;

        $updateForm = new UpdateForm($user->id);
        $updateForm->load($userData, '');

        return $updateForm->update($user);
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->getRequest();
        $userData = $request->getBodyParams();

        $user = User::findOne($id);
        $user->attributes = $userData;

        $updateForm = new UpdateForm($user->id);
        $updateForm->load($userData, '');

        return $updateForm->update($user);
    }

    public function actionUser($id)
    {
        $user = User::findOne($id);

        if ($user) {
            return $this->asJson($user);
        } else {
            throw new \yii\web\NotFoundHttpException('Пользователь не найден');
        }
    }

    public function actionCurrentUser()
    {
        $user = User::findOne(Yii::$app->user->id);

        if ($user) {
            return $this->asJson($user);
        } else {
            throw new \yii\web\NotFoundHttpException('Пользователь не найден');
        }
    }

    public function actionUsers()
    {
        $user = User::find()->all();

        if ($user) {
            return $this->asJson($user);
        } else {
            throw new \yii\web\NotFoundHttpException('Пользователь не найден');
        }
    }
}