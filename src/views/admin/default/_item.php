<?php

/**
 * @var $this \yii\web\View
 * @var $category \nullref\category\models\Category
 */
use yii\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;

$hasChildren = isset($category['children']);

?>

<li class="category-list-item"
    data-id="<?= $category['id'] ?>"
    data-update-url="<?= Url::to(['update', 'id' => $category['id']]) ?>">
    <div>
        <a class="btn btn-xs btn-primary drag-btn"><i class="fa fa-arrows"></i></a>
        <span><i class="icon-folder-open"></i><?= $category['title'] ?></span>
        <?= Html::a(FA::i(FA::_PENCIL), ['update', 'id' => $category['id']], ['class' => 'btn btn-xs btn-primary']) ?>
        <?= Html::a(FA::i(FA::_PLUS), ['create', 'parent_id' => $category['id']], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a(FA::i(FA::_TRASH), ['delete', 'id' => $category['id']], [
            'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post',],
            'class' => 'btn btn-xs btn-danger'
        ]) ?>

        <a href="#categoryList<?= $category['id'] ?>"
           class="btn btn-xs btn-primary collapse-list-btn <?= $hasChildren ? '' : 'disabled' ?>"
           role="button"
           data-toggle="collapse"
           aria-expanded="false" aria-controls="categoryList<?= $category['id'] ?>">
            <i class="fa <?= $hasChildren ? 'fa-arrow-down' : 'fa-arrow-up' ?>"></i>
        </a>
    </div>
    <ol id="categoryList<?= $category['id'] ?>" class="collapse category-list <?= $hasChildren ? '' : 'in' ?>">
        <?php if ($hasChildren): ?>
            <?php foreach ($category['children'] as $child): ?>
                <?= $this->render('_item', [
                    'category' => $child
                ]) ?>
            <?php endforeach; ?>
        <?php endif ?>
    </ol>
</li>
