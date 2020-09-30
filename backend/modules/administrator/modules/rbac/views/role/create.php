<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\administrator\modules\rbac\models\AuthItem */
/* @var $rolesNotOfThisRole array */
/* @var $rolesOfThisRole array */
/* @var $permissionsNotOfThisRole array */
/* @var $permissionsOfThisRole array */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['/admin/rbac/role']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">
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
