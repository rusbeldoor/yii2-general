<?php
namespace rusbeldoor\yii2General\gii\crud;

/**
 * ...
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
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField($attribute)
    {
        switch ($attribute) {
            default:
                $tableSchema = $this->getTableSchema();
                if ($tableSchema === false) { return "\$form->field(\$model, '$attribute')"; }
                switch ($tableSchema->columns[$attribute]->type) {
                    case 'datetime': return "\$form->field(\$model, '$attribute')->dateTime()";
                    case 'date': return "\$form->field(\$model, '$attribute')->date()";
                    default: return "\$form->field(\$model, '$attribute')";
                }
        }
    }

    /**
     * Generates code for active search field
     * @param string $attribute
     * @return string
     */
    public function generateActiveSearchField($attribute)
    {
        switch ($attribute) {
            case 'archive': return "\$form->field(\$model, 'archive')->searchNumberYesNo()";

            default:
                $tableSchema = $this->getTableSchema();
                if ($tableSchema === false) { return "\$form->field(\$model, '$attribute')"; }
                switch ($tableSchema->columns[$attribute]->type) {
                    case 'datetime': return "\$form->field(\$model, '$attribute')->dateTime()";
                    case 'date': return "\$form->field(\$model, '$attribute')->date()";
                    default: return "\$form->field(\$model, '$attribute')";
                }
        }
    }
}
