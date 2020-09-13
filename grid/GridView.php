<?php

namespace backend\widgets;

use yii;

use yii\grid\GridView as YiiGridView;
use yii\widgets\Pjax;

/**
 * GridView
 */
class GridView extends YiiGridView
{
    // Идентификатор формы-фильтра влияющей на GridView
    public $filter_form_selector = 'form.base-filter';

    // Номер для уникальности нескольких GridView на одной странице
    public static $number = 0;
    // Id Pjax контейнера (без символа "#")
    public $pjax_id = 'base-pjax-grid';
    // Id контейнера откуда берутся данные (без символа "#")
    public $fragment_id = 'base-pjax-fragment';

    // Шаблон вывода GridView
    public $layout = '<div class="grid-view-header clearfix">{summary}</div>{items}<div class="grid-view-footer clearfix">{pager}</div>';

    // Атрибуты тега table
    public $tableOptions = ['class' => 'table table-striped table-hover'];

    // Навигация по страницам
    public $pager = [
        'class' => 'yii\bootstrap4\LinkPager',
        'firstPageLabel' => 'Первая',
        'lastPageLabel'  => 'Последняя',
    ];

    /**
     *
     */
    public function init() {
        parent::init();

        self::$number++;
        $this->pjax_id .= '-' . self::$number;
        $this->fragment_id .= '-' . self::$number;
    }

    /**
     *
     */
    public function beforeRun()
    {
        if (!parent::beforeRun()) { return false; }

        // Обработка Pjax обновления
        // Обработка отправки форм bulk-action-form
        $this->getView()->registerJs(
        '$(document).ready(function() {
            function pjax_reload(data) {
                $.pjax.reload({
                    container: "#' . $this->pjax_id . '", 
                    type: "POST", 
                    fragment: "#' . $this->fragment_id . '", 
                    data: data
                });
            }
            $(document).on("submit", "' . $this->filter_form_selector . '", function() {
                pjax_reload($(this).serialize());
                return false;
            });
            $(document).on("reset", "' . $this->filter_form_selector . '", function() {
                setTimeout(function() {
                    pjax_reload($(this).serialize());
                }, 1);
            });
            
            $(document).on("submit", ".bulk-action-form", function() {
                var keys = $("#' . $this->fragment_id . ' .grid-view").yiiGridView("getSelectedRows");
                $(this).children("input[name=\'items\']").val(keys);
            });
        });');

        Pjax::begin(['id' => $this->pjax_id]);

        // Открываем контейнер-фрагмент для копирования из него при pjax загрузке
        echo '<div id="' . $this->fragment_id  . '">';

        return true;
    }

    /**
     *
     */
    public function afterRun($result)
    {
        $result = parent::afterRun($result);

        Pjax::end();

        return $result . '</div>';
    }
}
