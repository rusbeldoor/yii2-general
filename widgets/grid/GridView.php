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

    // Шаблон вывода GridView
    public $layout = '<div class="grid-view-header clearfix">{summary}</div>{items}<div class="grid-view-footer clearfix">{pager}</div>';

    // Атрибуты тега table
    public $tableOptions = ['class' => 'table table-striped table-hover'];

    // Навигация по страницам
    public $pager = [
        'class' => 'yii\bootstrap5\LinkPager',
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
    }

    /**
     *
     */
    public function beforeRun()
    {
        if (!parent::beforeRun()) { return false; }

        // Pjax обновление
        // Отправка формы
        // Сброс формы (отправка формы по умолчанию)
        // Реакция на успешное Pjax обновление (переход к таблице)
        // Обработка отправки форм bulkActionForm
        $this->getView()->registerJs(<<< JS
$(document).ready(function() {
    function pjaxReload(data, url) {
        $.pjax.reload({
            url: url,
            container: '#{$this->pjaxId}',
            type: 'POST',
            data: data
        });
    }
    $(document).on('submit', '{$this->searchFormSelector}', function() {
        pjaxReload($(this).serialize(), window.location.href);
        return false;
    });
    $(document).on('reset', '{$this->searchFormSelector}', function() {
        setTimeout(function() { pjaxReload($(this).serialize()); }, 1);
    });
    $(document).on("pjax:success", "#{$this->pjaxId}",  function(event) { 
        window.scrollTo({top: $('#{$this->pjaxId}').offset().top, behavior: 'smooth'});
    });
    $(document).on('change', '.bulkActionColumnCheckbox', function() {
        $('.bulkActionFormButton').prop('disabled', (($('#{$this->pjaxId} .grid-view').find('.bulkActionColumnCheckbox:checked').length) ? false : true));
    });
    $(document).on('submit', '.bulkActionForm', function() {
        var keys = $('#{$this->pjaxId} .grid-view').yiiGridView('getSelectedRows');
        $(this).children('input[name="items"]').val(keys);
    });
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        pjaxReload($('{$this->searchFormSelector}').serialize(), $(this).attr('href'));
        return false;
    });
    $(document).on('click', '#{$this->pjaxId} .grid-view table thead tr th a', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) { pjaxReload($('{$this->searchFormSelector}').serialize(), href); }
        return false;
    });
});
        JS);

        Pjax::begin([
            'id' => $this->pjaxId,
            'linkSelector' => 'pjax-link',
        ]);

        return true;
    }

    /**
     *
     */
    public function afterRun($result)
    {
        $result = parent::afterRun($result);

        Pjax::end();

        return $result;
//        return $result . '</div>';
    }
}
