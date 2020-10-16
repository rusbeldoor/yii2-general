<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
/* @var $rolesNotOfThisRole array */
/* @var $rolesOfThisRole array */
/* @var $permissionsNotOfThisRole array */
/* @var $permissionsOfThisRole array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['/administrator/rbac/role']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="auth-item-update">
    <?= $this->render(
        '_form',
        [
            'model' => $model,
            'rolesNotOfThisRole' => $rolesNotOfThisRole,
            'rolesOfThisRole' => $rolesOfThisRole,
            'permissionsNotOfThisRole' => $permissionsNotOfThisRole,
            'permissionsOfThisRole' => $permissionsOfThisRole,
        ]
    ) ?>
</div>
