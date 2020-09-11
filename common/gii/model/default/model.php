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
    'name' => 'Название',
    'status' => 'Статус',
    'title' => 'Заголовок',
    'email' => 'Электронная почта',
    'phone' => 'Телефон',
    'firstname' => 'Имя',
    'lastname' => 'Фамилия',
    'middlename' => 'Отчество',
    'datetime_create' => 'Дата и время создания',
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
class <?= $className ?> extends \rusbeldoor\yii2General\common\models\ActiveRecord
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
<?php
foreach ($labels as $name => $label) {
    echo "            ";
    if (isset($attributeLabels[$name])) {
        echo "'" . $name . "' => '" . $label . "'";
    } else { echo "'$name' => " . $generator->generateString($label); }

/*    switch ($name) {
        case 'id': echo "'id' => 'Ид'"; break;
        case 'alias': echo "'alias' => 'Алиас'"; break;
        case 'name': echo "'name' => 'Название'"; break;
        case 'status': echo "'status' => 'Статус'"; break;
        case 'title': echo "'title' => 'Заголовок'"; break;
        case 'email': echo "'email' => 'Электронная почта'"; break;
        case 'phone': echo "'phone' => 'Телефон'"; break;
        case 'firstname': echo "'firstname' => 'Имя'"; break;
        case 'lastname': echo "'lastname' => 'Фамилия'"; break;
        case 'middlename': echo "'middlename' => 'Отчество'"; break;
        case 'datetime_create': echo "'datetime_create' => 'Дата и время создания'"; break;
        case 'archive': echo "'archive' => 'Архив'"; break;
        default: echo "'$name' => " . $generator->generateString($label);
    } */

    echo ",\n";
}
?>
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
<?php endif; ?>
}
