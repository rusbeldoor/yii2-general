<?php
/**
 * @var yii\web\View $this
 * @var backend\modules\administrator\modules\rbac\models\AuthItem $model
 * @var array $rolesNotOfThisRole
 * @var array $rolesOfThisRole
 * @var array $permissionsNotOfThisRole
 * @var array $permissionsOfThisRole
 */

$this->title = 'Добавление';
$this->context->addBreadcrumb('Роли', ['/administrator/rbac/role']);
$this->context->addBreadcrumb('Добавление');
?>

<div class="auth-item-create">
    <?= $this->render('_form', [
        'model' => $model,
        'rolesNotOfThisRole' => $rolesNotOfThisRole,
        'rolesOfThisRole' => $rolesOfThisRole,
        'permissionsNotOfThisRole' => $permissionsNotOfThisRole,
        'permissionsOfThisRole' => $permissionsOfThisRole,
    ]) ?>
</div>
