<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

$attributeLabels = [
    'id' => 'Ид',
    'alias' => 'Алиас',
    'user_id' => 'Пользователь',
    'template_id' => 'Шаблон',
    'type' => 'Тип',
    'name' => 'Название',
    'status' => 'Статус',
    'from' => 'От',
    'title' => 'Заголовок',
    'text' => 'Текст',
    'description' => 'Описание',
    'email' => 'Электронная почта',
    'phone' => 'Телефон',
    'firstname' => 'Имя',
    'lastname' => 'Фамилия',
    'middlename' => 'Отчество',
    'sex' => 'Пол',
    'datetime_birthday' => 'День рождения',
    'age' => 'Возраст',
    'publish' => 'Публикация',
    'datetime_create' => 'Дата и время создания',
    'datetime_update' => 'Дата и время обновления',
    'datetime_remove' => 'Дата и время удаления',
    'datetime_send' => 'Дата и время отправки',
    'datetime_start' => 'Дата и время начала',
    'datetime_complete' => 'Дата и время завершения',
    'active' => 'Активный',
    'archive' => 'Архив',
];

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
 * <?= ucfirst($generator->generateTableName($tableName)) ?> (ActiveRecord)
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "\${$property} {$data['type']}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
 */
class <?= $className ?> extends \rusbeldoor\yii2General\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    { return '<?= $generator->generateTableName($tableName) ?>'; }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection
     */
    public static function getDb()
    { return Yii::$app->get('<?= $generator->db ?>'); }
<?php endif; ?>

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label) {
    echo "            ";
    echo ((isset($attributeLabels[$name])) ? "'$name' => '" . $attributeLabels[$name] . "'" : "'" . $name . "' => " . $generator->generateString($label));
    echo ",\n";
} ?>
        ];
    }
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     *
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    { return new <?= $queryClassFullName ?>(get_called_class()); }

    /**
     * Перед удалением
     *
     * @return bool
     */
    public function beforeDelete()
    {
        // if (true) { $this->addError('id', 'Элемент #' . $this->id . ' не может быть удалён.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
<?php endif; ?>
}
