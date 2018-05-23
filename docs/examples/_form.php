<?php

use nullref\category\helpers\Fancytree;
use nullref\category\models\Category;
use wbraganca\fancytree\FancytreeWidget;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \Product */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(<<<JS
window.selectTreeNode = function () {
    jQuery('#fancyree_categoriesTree').fancytree("getTree").generateFormElements("Product[categoriesList][]");
};


JS
);

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <div>
        <?= $form->errorSummary([$model]) ?>
    </div>
    <div class="row">
        <div class="col-md-6">

            <?= $form->beginField($model, 'categoriesList') ?>
            <?= Html::activeLabel($model, 'categoriesList') ?>
            <?= FancytreeWidget::widget([
                'id' => 'categoriesTree',
                'options' => Fancytree::getFancytreeOptions([
                    'init' => new JsExpression('window.selectTreeNode'),
                    'select' => new JsExpression('window.selectTreeNode'),
                    'source' => Category::getNestedList($model->categoriesList),
                ])
            ]) ?>
            <?= $form->endField() ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
