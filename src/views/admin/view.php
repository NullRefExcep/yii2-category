<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model nullref\category\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$attributes = [
    'title',
    'description:ntext',
    'createdAt:datetime',
    'updatedAt:datetime',
];
    $additional[] = 'parentId';
    $additional[] = 'image:image';
    $additional[] = 'status:boolean';
array_splice($attributes, 1, 0, $additional);
?>
<div class="category-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('category', 'List'), ['index',], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('category', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('category', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('category', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
