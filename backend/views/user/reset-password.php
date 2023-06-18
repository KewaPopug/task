<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChangePasswordForm */
/* @var $form ActiveForm */

$this->title = 'Change Password';
?>
<div class="user-changePassword">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'old_password')->passwordInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'confirm_password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>