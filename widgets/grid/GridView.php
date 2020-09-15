<?php

namespace rusbeldoor\yii2General\widgets\grid;

use yii;
use yii\widgets\Pjax;

/**
 * GridView
 */
class GridView extends \yii\grid\GridView
{
    // Номер для уникальности нескольких GridView на одной странице
    public static $number = 0;

    // Селектор формы поиска
    public $searchFormSelector = '.panelSearchForm';
    // Id Pjax контейнера
    public $pjaxId = 'panelPjaxGrid';
    // Id контейнера откуда берутся данные
    public $fragmentId = 'panelPjaxFragment';

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
        $this->pjaxId .= self::$number;
        $this->fragmentId .= self::$number;
    }

    /**
     *
     */
    public function beforeRun()
    {
        if (!parent::beforeRun()) { return false; }

        // Pjax обновлениие
        // Отправка формы
        // Сброс формы (отправка формы по умолчанию)
        // Реакция на успешное Pjax обновление (переход к таблице)
        // Обработка отправки форм bulk-action-form
        $this->getView()->registerJs(
            '$(document).ready(function() {
    function pjaxReload(data) {
        $.pjax.reload({
            container: \'#' . $this->pjaxId . '\', 
            type: \'POST\', 
            fragment: \'#' . $this->fragmentId . '\', 
            data: data
        });
    }
    $(document).on(\'submit\', \'' . $this->searchFormSelector . '\', function() {
        pjaxReload($(this).serialize());
        return false;
    });
    $(document).on(\'reset\', \'' . $this->searchFormSelector . '\', function() {
        setTimeout(function() { pjaxReload($(this).serialize()); }, 1);
    });
    $(document).on("pjax:success", "#' . $this->pjaxId . '",  function(event) { 
        window.scrollTo({top: $(\'#' . $this->pjaxId . '\').offset().top, behavior: \'smooth\'});
    });
    $(document).on(\'submit\', \'.bulk-action-form\', function() {
        var keys = $(\'#' . $this->fragmentId . ' .grid-view\').yiiGridView(\'getSelectedRows\');
        $(this).children(\'input[name="items"]\').val(keys);
    });
});'
        );

        Pjax::begin(['id' => $this->pjaxId]);

        // Открываем контейнер-фрагмент для копирования из него при pjax загрузке
        echo '<div id="' . $this->fragmentId  . '">';

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
