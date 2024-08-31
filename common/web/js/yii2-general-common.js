$(document).ready(function() {
    /*** Select2 ***/

    /**
     * Фикс ошибки (если список выводится в скрытом элементе у него ширина расчитывается как 0, что не верно и placeholder может обрезаться)
     * В версии 4.1.* ошибка решена, но версия не стабильная и пакет kartik-v/yii2-widget-select2 использует пока только стабильную версию
     */
    setTimeout(function() {
        $('.select2 .select2-selection__rendered .select2-search.select2-search--inline .select2-search__field').css("width", "100%");
    }, 1000);

    /*** Widgets ***/

    $.fn.radioButtonsListValue = function() {
        return $(this).children('button.active').children('input').val();
    };

    $('input[type="radio"]').change(function() {
        $(this).parent().parent().find('label').removeClass('active');
        $(this).parent().addClass('active');
    });
});

/**
 * Генератор модального окна подтверждения действия
 *
 * Важно! При выводе модального окна подтверждения действия поверх другого модального окна,
 * необходимо применить к первоначальному модальному окну настройки: modal({keyboard: false, show: false});
 * Это предотвращает скрытие первоначального окна (при выводе поверх него окна подтверждения) при нажатии [Esc]
 */
function confirmDialog(params) {
    if (typeof(params) == 'undefined') { return; }
    if (typeof(params.text) == 'undefined') { return; }
    if (typeof(params.confirm) == 'undefined') { params.confirm = true; }
    if (typeof(params.confirmText) == 'undefined') { params.confirmText = 'Продолжить'; }
    if (typeof(params.cancel) == 'undefined') { params.cancel = true; }
    if (typeof(params.cancelText) == 'undefined') { params.cancelText = 'Отмена'; }
    if (typeof(params.confirmCallback) == 'undefined') { params.confirmCallback = () => {}; }
    if (typeof(params.cancelCallback) == 'undefined') { params.cancelCallback = () => {}; }

    let $confirmModal = $('#confirmModal');

    if (!$confirmModal.length) {
        $('body').append(
            '<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">'
                + '<div class="modal-dialog" role="document">'
                    + '<div class="modal-content">'
                        + '<div class="modal-body"></div>'
                        + '<div class="modal-footer"></div>'
                    + '</div>'
                + '</div>'
            + '</div>');

        $confirmModal = $('#confirmModal');

        $confirmModal.modal({
            backdrop: 'static',
            // backdrop: true,
            keyboard: true,
            show: false
        });

        $confirmModal.on('click', 'button[data-confirm="false"]', function () {
            $confirmModal.modal('hide');
        });

        $confirmModal.on('hidden', function () {
            $confirmModal.find('.modal-body').html('');
        });
    }

    // Заполняем модальное окно
    $confirmModal.find('.modal-body').html(params.text);
    $confirmModal.find('.modal-footer').html(
        ((params.confirm) ? '<button class="btn btn-primary" data-confirm-modal="true">' + params.confirmText + '</button>' : '')
        + ((params.cancel) ? '<button class="btn btn-default" data-confirm-modal="false">' + params.cancelText + '</button>' : '')
    );

    // Убираем события для продолжения
    $confirmModal.off('click', 'button[data-confirm-modal="true"]');

    // Убираем события для отмены
    $confirmModal.off('click', 'button[data-confirm-modal="false"]');

    // Добавляем событие для продолжения
    $confirmModal.on('click', 'button[data-confirm-modal="true"]', function () {
        $confirmModal.modal('hide');
        params.confirmCallback();
    });

    // Добавляем событие для продолжения
    $confirmModal.on('click', 'button[data-confirm-modal="false"]', function () {
        $confirmModal.modal('hide');
        params.cancelCallback();
    });

    $confirmModal.modal('show');
};