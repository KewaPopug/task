<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */


//var_dump($model);
//die();

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <div class="container">
        <div id="main">

            <p>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Смена пароля', ['reset-password', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить аккаунт', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <div class="row" id="real-estates-detail">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="panel-default">
                        <div class="panel-body">
                            <div class="text-center" id="author">
                                <img src="/<?= $model->photo_url; ?>" width="222px" height="222px">
                                <h3><?= $model->username; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="myTabContent" class="tab-content">
                                <div id="detail">
                                    <h4>История профиля</h4>
                                    <table class="table table-th-block">
                                        <div id="detail">
                                            <?= DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    [
                                                        'label' => 'Фамилия',
                                                        'attribute' => 'surname'
                                                    ],
                                                    [
                                                        'label' => 'Имя',
                                                        'attribute' => 'firstname'
                                                    ],
                                                    [
                                                        'label' => 'Отчество',
                                                        'attribute' => 'patronymic'
                                                    ],
                                                    [
                                                        'label' => 'Email',
                                                        'format' => 'email',
                                                        'attribute' => 'email'
                                                    ],
                                                    [
                                                        'label' => 'ИИН',
                                                        'attribute' => 'individual_identification_number'
                                                    ],
                                                    [
                                                        'label' => 'Дата рождения',
                                                        'attribute' => 'date_born'
                                                    ],
                                                    [
                                                        'label' => 'Пользовательское Имя',
                                                        'attribute' => 'username'
                                                    ],
                                                ],
                                            ]) ?>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.main -->
</div><!-- /.container -->
<br />
