<?php

namespace rusbeldoor\yii2General\common\widgets\grid;

use Yii;
use yii\widgets\Pjax;

/**
 * GridView
 */
class GridView extends \yii\grid\GridView
{
    public static $number = 0;

    public $pjax_id = 'standart-pjax-grid';
    public $fragment_id = 'standart-pjax-fragment';

    // Идентификатор формы фильтра
    public $search_form_id = 'standard-search-form';

    public $pager = [
        'class' => 'yii\bootstrap4\LinkPager',
        'firstPageLabel' => 'Первая',
        'lastPageLabel'  => 'Последняя',
    ];

    public function init() {
        parent::init();

        self::$number++;
        $this->pjax_id .= self::$number;
        $this->fragment_id .= self::$number;

    }

    public function beforeRun()
    {
        if (!parent::beforeRun()) { return false; }

        $this->getView()->registerJs('
            $("document").ready(function() {
                $(document).on("submit", "#' . $this->search_form_id . '", function() {
                    $.pjax.reload({
                        container: "#' . $this->pjax_id . '", 
                        type: "POST", 
                        fragment: "#' . $this->fragment_id . '", 
                        data: $(this).serialize()
                    });
                    return false;
                });
                $(document).on("reset", "#' . $this->search_form_id . '", function() {
                    setTimeout(function() {
                        $.pjax.reload({
                            container: "#' . $this->pjax_id . '", 
                            type: "POST", 
                            fragment: "#' . $this->fragment_id . '", 
                            data: $(this).serialize()
                        });
                    }, 1);
                });
            });
        ');

        Pjax::begin(['id' => $this->pjax_id]);

        // Открываем контейнер-фрагмент для копирования из него при pjax загрузке
        echo '<div id="' . $this->fragment_id  . '">';

        return true;
    }

    public function afterRun($result)
    {
        $result = parent::afterRun($result);

        Pjax::end();

        // Закрываем контейнер-фрагмент для копирования из него при pjax загрузке
        $result .= '</div>';

        return $result;
    }
}
