<?php

namespace rusbeldoor\yii2General\widgets\grid;

use Yii;
use yii\helpers\Html;

/**
 *
 */
class ArchiveColumn extends \yii\grid\ActionColumn
{
    const ARCHIVE_CLASS = 'colorArchive';
    const NOT_ARCHIVE_CLASS = 'colorNotArchiv';

    // Атрибуты тега th
    public $headerOptions = ['class' => 'actionColumnHeader archiveColumnHeader'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'actionColumn archiveColumn'];
    // Атрибуты тега button
    public $buttonOptions = ['class' => 'actionColumnButton archiveColumnButton'];

    // Шаблон вывода
    public $template = '{archive}';

    // Заголовок столбца
    public $header = 'Архив';

    /**
     *
     */
    public function init()
    {
        parent::init();

        Yii::$app->getView()->registerJs(
'$(document).on(\'click\', \'.archiveColumnButton\', function() {
    let archive_action = $(this);
    $.post(
        \'' . Yii::$app->requestedRoute . '/archive\',
        {id: $(this).data(\'id\')}
    ).done(function(data) {
        if (data.result) {
            archive_action.toggleClass(\'' . self::ARCHIVE_CLASS . '\');
            archive_action.toggleClass(\'' . self::NOT_ARCHIVE_CLASS . '\');
        }
    });
    return false;
});'
        );
    }

    /**
     *
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('archive', 'fas fa-archive');
    }

    /**
     *
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && (strpos($this->template, '{' . $name . '}') !== false)) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'archive':
                        if ($model->archive) {
                            $archiveClass = self::ARCHIVE_CLASS;
                            $title = 'Разархивировать (в архиве)';
                        } else {
                            $archiveClass = self::NOT_ARCHIVE_CLASS;
                            $title = 'Архивировать (не в архиве)';
                        }
                        break;

                    default:
                        $archiveClass = self::NOT_ARCHIVE_CLASS;
                        $title = 'Архивировать (не в архиве)';
                }
                return Html::tag(
                    'i',
                    '',
                    [
                        'title' => $title,
                        'class' =>  $this->buttonOptions['class'] . ' ' . $iconName . ' ' . $archiveClass,
                        'data-id' => $model->id,
                    ]
                );
            };
        }
    }
}
