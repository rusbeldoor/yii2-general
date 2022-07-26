<?php

namespace rusbeldoor\yii2General\helpers;

use Yii;
use rusbeldoor\yii2General\helpers\HtmlHelper;

/**
 * Базовый интерфейс
 */
class BaseUI
{
    /**
     * Кнопки для главной страицы
     *
     * @param array $buttons
     * @return string
     */
    public static function buttonsForIndexPage($buttons = [])
    {
        $result = [];

        foreach ($buttons as $param) {
            switch ($param) {
                case 'add':
                    $result[] = HtmlHelper::a('<i class="fas fa-plus"></i>&nbsp;&nbsp;Добавить', ['create'], ['class' => 'btn btn-success']);
                    break;

                case 'delete':
                    $result[] =
                        HtmlHelper::beginForm(['delete'],'post', ['class' => 'bulkActionForm displayInlineBlock'])
                            . HtmlHelper::submitButton(
                                '<i class="far fa-trash-alt"></i>&nbsp;&nbsp;Удалить',
                                [
                                    'class' => 'btn btn-danger bulkActionFormButton',
                                    'disabled' => true,
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]
                            )
                            . HtmlHelper::hiddenInput('items', '')
                        . HtmlHelper::endForm();
                    break;

                default:
            }
        }

        return
            '<div class="panelButtonsGroup clearfix">'
                . ((in_array('filter', $buttons)) ? HtmlHelper::button('<i class="fas fa-filter"></i>&nbsp;&nbsp;Фильтр', ['class' => 'btn btn-light panelSearchFormToggle']) : '')
                . '<div class="float-end">'
                    . implode('&nbsp;&nbsp;&nbsp;', $result)
                . '</div>'
            . '</div>';
    }

    /**
     * Кноаки для страницы отображения
     *
     * @param mixed $model
     * @param array $buttons
     * @return string
     */
    public static function buttonsForViewPage($model, $buttons = [])
    {
        $result = [];

        foreach ($buttons as $param) {
            switch ($param) {
                case 'add':
                    $result[] = HtmlHelper::a('<i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-success']);
                    break;

                case 'delete':
                    $result[] = HtmlHelper::a('<i class="far fa-trash-alt"></i>&nbsp;&nbsp;Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                    break;

                default:
            }
        }

        return
            '<div class="panelButtonsGroup clearfix">'
                . '<div class="float-end">'
                    . implode('&nbsp;&nbsp;&nbsp;', $result)
                . '</div>'
            . '</div>';
    }

    /**
     * Кнопки для формы фильтра
     *
     * @return string
     */
    public static function buttonsForSearchForm()
    {
        return
            '<div class="form-group row">'
                . '<div class="col-2"></div>'
                . '<div class="col-10">'
                    . HtmlHelper::submitButton('Применить', ['class' => 'btn btn-primary'])
                    . '&nbsp;&nbsp;&nbsp;'
                    . HtmlHelper::resetButton('<i class="fas fa-wind"></i> Сбросить', ['class' => 'btn btn-outline-secondary'])
                . '</div>'
            . '</div>';
    }

    /**
     * Кнопки для формы добавления/изменения
     *
     * @param mixed $model
     * @return string
     */
    public static function buttonsForAddOrEditForm($model)
    {
        return
            '<div class="form-group row">'
                . '<div class="col-2"></div>'
                . '<div class="col-10">'
                    . HtmlHelper::submitButton((($model->isNewRecord) ? '<i class="fas fa-plus"></i>&nbsp;&nbsp;Добавить' : '<i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Изменить'), ['class' => 'btn btn-success'])
                    . '&nbsp;&nbsp;&nbsp;'
                    . HtmlHelper::a('<i class="fas fa-times"></i>&nbsp;&nbsp;Отмена', Yii::$app->request->referrer,  ['class' => 'btn btn-outline-secondary'])
                . '</div>'
            . '</div>';
    }
}
