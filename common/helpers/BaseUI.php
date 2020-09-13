<?php

namespace common\helpers;

use yii;
use yii\helpers\Html;

/**
 *
 */
class BaseUI
{
    public static function buttonsManageForIndex($buttons = ['filter', 'add', 'delete']) {
        $result = [];

        foreach ($buttons as $param) {
            switch ($param) {
                case 'add':
                    $result[] = Html::a('<i class="icon-plus"></i>&nbsp;&nbsp;Добавить', ['create'], ['class' => 'btn btn-success']);
                    break;

                case 'delete':
                    $result[] = ''
                    .Html::beginForm(['delete'],'post', ['class' => 'bulk-action-form'])
                    .Html::submitButton(
                        '<i class="icon-trash"></i>&nbsp;&nbsp;Удалить',
                        [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]
                    )
                    .Html::hiddenInput('items', '')
                    .Html::endForm()
                    .'';
                    break;

                default:
            }
        }

        return ''
        .'<div class="base-buttons-manage clearfix">'
            .((in_array('filter', $buttons)) ? Html::button('<i class="icon-filter"></i>&nbsp;&nbsp;Фильтр', ['class' => 'btn btn-light base-button-filter-form']) : '')
            .'<div class="float-right">'
                .implode('&nbsp;&nbsp;&nbsp;', $result)
            .'</div>'
        .'</div>'
        .'';
    }

    public static function buttonsManageForView($model, $buttons = ['add', 'delete']) {
        $result = [];

        foreach ($buttons as $param) {
            switch ($param) {
                case 'add':
                    $result[] = Html::a('<i class="icon-pencil"></i>&nbsp;&nbsp;Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-success']);
                    break;

                case 'delete':
                    $result[] = Html::a('<i class="icon-trash"></i>&nbsp;&nbsp;Удалить', ['delete', 'id' => $model->id], [
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

        return ''
        .'<div class="base-buttons-manage clearfix">'
            .'<div class="float-right">'
                .implode('&nbsp;&nbsp;&nbsp;', $result)
            .'</div>'
        .'</div>'
        .'';
    }

    public static function buttonsFilterForm() {
        return ''
        .'<div class="form-group">'
            .Html::submitButton('<i class="icon-ok"></i>&nbsp;&nbsp;Применить', ['class' => 'btn btn-primary'])
            .'&nbsp;&nbsp;&nbsp;'
            .Html::resetButton('<i class="icon-remove"></i>&nbsp;&nbsp;Сбросить', ['class' => 'btn btn-outline-secondary'])
        .'</div>'
        .'';
    }

    public static function buttonsAddEditForm($model) {
        return ''
        .'<div class="form-group">'
            .Html::submitButton((($model->isNewRecord) ? '<i class="icon-plus"></i>&nbsp;&nbsp;Добавить' : '<i class="icon-pencil"></i>&nbsp;&nbsp;Изменить'), ['class' => 'btn btn-success'])
            .'&nbsp;&nbsp;&nbsp;'
            .Html::a('<i class="icon-remove"></i>&nbsp;&nbsp;Отмена', Yii::$app->request->referrer,  ['class' => 'btn btn-outline-secondary'])
        .'</div>'
        .'';
    }
}
