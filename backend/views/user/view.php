<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Reset password', ['reset-password', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<div class="container">
    <div id="main">
        <div class="row" id="real-estates-detail">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="panel-default">
                    <div class="panel-body">
                        <div class="text-center" id="author">
                            <img src="<?=Yii::getAlias("@frontendUrl") . '/'. $model->photo_url ?>" width="222px" height="222px" alt="profile_photo">
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
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'label' => 'id',
                                            'attribute' => 'id'
                                        ],
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
                                        [
                                            'label' => 'Статус активации',
                                            'attribute' => 'status'
                                        ],
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.main -->
</div><!-- /.container -->

