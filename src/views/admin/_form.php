<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nullref\category\models\Category */
/* @var $form yii\widgets\ActiveForm */
/** @var $manager \nullref\category\components\EntityManager */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if ($manager->hasParent): ?>
        <?= $form->field($model, 'parentId')->
        dropDownList($manager->getMap('id', 'title', ['not in', 'id', isset($model->id) ? $model->id : 0]), ['prompt' => Yii::t('app', 'N/A')]) ?>
    <?php endif ?>

    <?php if ($manager->hasImage): ?>
        <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
    <?php endif ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if ($manager->hasStatus): ?>
        <?= $form->field($model, 'status')->textInput() ?>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('category', 'Create') : Yii::t('category', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
