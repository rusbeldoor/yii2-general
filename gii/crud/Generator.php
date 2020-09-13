<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace rusbeldoor\yii2General\gii\crud;

use yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 * read-only.
 * @property string $nameAttribute This property is read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property bool|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controller view path. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    /**
     * Generates parameter tags for phpdoc
     * @return array parameter tags for phpdoc
     */
    public function generateActionParamComments()
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if (($table = $this->getTableSchema()) === false) {
            $params = [];
            foreach ($pks as $pk) {
                $params[] = '@param $' . $pk . ' ' . (strtolower(substr($pk, -2)) === 'id' ? 'integer' : 'string');
            }

            return $params;
        }
        if (count($pks) === 1) {
            return ['@param $id ' . $table->columns[$pks[0]]->phpType];
        }

        $params = [];
        foreach ($pks as $pk) {
            $params[] = '@param $' . $pk . ' ' . $table->columns[$pk]->phpType;
        }

        return $params;
    }

    /**
     * Generates code for active search field
     * @param string $attribute
     * @return string
     */
    public function generateActiveSearchField($attribute)
    {
        switch ($attribute) {
            case 'archive':
                return
                    "\$form->field(\$model, 'archive', ['inline'=>true])->radioList(
                        ['' => 'Не важно', '1' => 'Да', '0' => 'Нет'],
                        [
                            'class' => 'btn-group',
                            'data-toggle' => 'buttons',
                            'unselect' => null,
                            'item' => function (\$index, \$label, \$name, \$checked, \$value) {
                                return
                                    '<label class=\"btn btn-secondary' . (\$checked ? ' active' : '') . '\">'
                                        . Html::radio(\$name, \$checked, ['value' => \$value, 'class' => 'project-status-btn']) . ' ' . \$label
                                    . '</label>';
                            },
                        ]
                    )";
                break;

            default:
                $tableSchema = $this->getTableSchema();
                if ($tableSchema === false) { return "\$form->field(\$model, '$attribute')"; }
                $column = $tableSchema->columns[$attribute];
                if ($column->phpType === 'boolean') { return "\$form->field(\$model, '$attribute')->checkbox()"; }
                return "\$form->field(\$model, '$attribute')";
        }
    }
}
