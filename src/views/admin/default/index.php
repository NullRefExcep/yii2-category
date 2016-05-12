<?php

use yii\helpers\Html;
use nullref\category\assets\CategoryTreeAsset;
use yii\web\View;

/**
 * @var $this View
 * @var $id integer
 * @var $formName string
 * @var $categories \nullref\category\models\Category []
 */

$this->registerJs("var selectedCategoryId = $id;", View::POS_BEGIN);
CategoryTreeAsset::register($this);


$this->title = Yii::t('category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>
    <p>
        <?= Html::a(Yii::t('category', 'Add Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="tree" id="treeView" data-form-name="<?= $formName ?>">
        <?php if (count($categories)): ?>
            <ol class="category-list">
                <?php foreach ($categories as $category): ?>
                    <?= $this->render('_item', [
                        'category' => $category
                    ]) ?>
                <?php endforeach; ?>
            </ol>
        <?php endif ?>
    </div>
</div>
