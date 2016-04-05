<?php
use yii\helpers\Html;

/**
 * @var $model \nullref\category\models\Category
 * @var $key mixed
 * @var $index integer
 * @var $widget \yii\widgets\ListView
 * @var $this \yii\web\View
 */

?>
<div data-id="<?= $key ?>" class="well">
    <?= Html::a($model->title, ['/category/default/view', 'id' => $model->id]) ?>
</div>

