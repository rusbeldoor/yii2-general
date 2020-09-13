<?php

namespace rusbeldoor\yii2General\widgets\grid;

use yii;
use yii\helpers\Html;

/**
 *
 */
class ArchiveColumn extends \yii\grid\ActionColumn
{
    const ARCHIVE_CLASS = 'color-archive';
    const NOT_ARCHIVE_CLASS = 'color-not-archive';

    // Атрибуты тега th
    public $headerOptions = ['class' => 'action-column-header archive-column-header'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'action-column archive-column'];

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
'$(document).on(\'click\', \'.archive-column-button\', function() {
    let archive_action = $(this);
    $.post(
        \'/mailing-template/archive\',
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
                            $title = 'В архиве';
                        } else {
                            $archiveClass = self::NOT_ARCHIVE_CLASS;
                            $title = 'Не в архиве';
                        }
                        break;

                    default:
                        $archiveClass = self::NOT_ARCHIVE_CLASS;
                        $title = 'Не в архиве';
                }
                return Html::tag(
                    'i',
                    '',
                    [
                        'title' => $title,
                        'class' =>  'action-column-button archive-column-button ' . $iconName . ' ' . $archiveClass,
                        'data-id' => $model->id,
                    ]
                );
            };
        }
    }
}
