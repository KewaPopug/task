<?php

namespace frontend\controllers;

use common\models\UpdateForm;
use common\models\User;
use common\models\ChangePasswordForm;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ProfileController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('view', [
            'model' => $this->findModel(\Yii::$app->user->id),
        ]);
    }

    public function actionResetPassword()
    {
        $model = new ChangePasswordForm(\Yii::$app->user->id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            \Yii::$app->session->setFlash('success', 'Password Changed!');
            $this->redirect('index');
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new UpdateForm($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->update($model)) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
