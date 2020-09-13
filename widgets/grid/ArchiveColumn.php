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

    // Номер для уникальности нескольких ArchiveColumn на одной странице
    public static $number = 0;

    // Атрибуты тега th
    public $headerOptions = ['class' => 'action-column-header archive-column-header'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'action-column archive-column'];
    // Атрибуты тега button
    public $buttonOptions = ['class' => 'action-column-button archive-column-button'];

    // Шаблон вывода
    public $template = '{archive}';

    // Заголовок столбца
    public $header = 'Архив';

    // Class span контейнера с иконкой (без символа ".")
    public $span_class = 'archive-action';

    /**
     *
     */
    public function init()
    {
        parent::init();

        self::$number++;
        $this->span_class .= '-' . self::$number;

        Yii::$app->getView()->registerJs(
'$(document).on(\'click\', \'.' . $this->span_class. '\', function() {
    let archive_action = $(this);
    $.post(
        \'archive\',
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
                $options = array_merge([
                    'title' => $title,
                    'data-id' => $model->id,
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('i', '', ['class' => $this->span_class . ' ' . $iconName . ' ' . $archiveClass]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
