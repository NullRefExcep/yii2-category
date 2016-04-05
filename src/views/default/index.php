<?php
use yii\widgets\ListView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */
$this->title = Yii::t('category', 'Categories');
?>

<div class="category-index">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
    ]) ?>
</div>
