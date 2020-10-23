<?php
namespace rusbeldoor\yii2General\widgets;

/**
 * DetailView
 */
class DetailView extends \yii\widgets\DetailView
{
    // Атрибуты тега table
    public $options = ['class' => 'table table-striped table-hover'];

    /**
     *
     */
    public function beforeRun()
    {
        if (!parent::beforeRun()) { return false; }

        // Открываем контейнер
        echo '<div class="detail-view">';

        return true;
    }

    /**
     *
     */
    public function afterRun($result)
    {
        $result = parent::afterRun($result);

        return $result . '</div>';
    }
}
