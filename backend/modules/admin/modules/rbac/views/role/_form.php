<?php

use rusbeldoor\yii2General\widgets\AddEditForm;
use kartik\sortable\Sortable;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\rbac\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">
    <?php $form = AddEditForm::begin() ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description') ?>
    <?
    echo Sortable::widget([
        'connected'=>true,
        'items'=>[
            ['content'=>'From Item 1'],
            ['content'=>'From Item 2'],
            ['content'=>'From Item 3'],
            ['content'=>'From Item 4'],
        ]
    ]);
    echo Sortable::widget([
        'connected'=>true,
        'itemOptions'=>['class'=>'alert alert-warning'],
        'items'=>[
            ['content'=>'To Item 1'],
            ['content'=>'To Item 2'],
            ['content'=>'To Item 3'],
            ['content'=>'To Item 4'],
        ]
    ]);
    echo '<div class="clearfix"></div>';
    ?>
    <?= $form->buttons($model) ?>
    <?php AddEditForm::end() ?>
</div>
