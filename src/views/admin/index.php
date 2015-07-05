<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel nullref\category\models\SearchCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    'title',
    'createdAt:datetime',
    'updatedAt:datetime',

    ['class' => 'yii\grid\ActionColumn'],
];
/** @var \nullref\category\components\EntityManager $manager */
$manager = $this->context->getManager();
$additional = [];
if ($manager->hasParent) {
    $additional[] = 'parentId';
}
if ($manager->hasImage) {
    $additional[] = 'image:image';
}
if ($manager->hasStatus) {
    $additional[] = 'status:boolean';
}
array_splice($columns, 2, 0, $additional);
?>
<div class="category-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('category', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>

</div>
