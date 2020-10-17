/*********************************
 *** *** *** Интерфейс *** *** ***
 *********************************/

$(document).ready(function() {
    // Отображение/скрытие окна формы поиска
    $('.panelSearchFormToggle').click(function () {
        $('.panelSearchFormContainer').toggle();
        return false;
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
            '<div id="confirmModal" class="modal hide" data-toggle="modal">'
            + '<div class="modal-content">'
            + '<div class="modal-body"></div>'
            + '<div class="modal-footer"></div>'
            + '</div>'
            + '</div>'
        );

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

    $confirmModal.find('.modal-body').html(params.text);

    $confirmModal.find('.modal-footer').html(
        ((params.confirm) ? '<button class="btn btn-primary" data-confirm="true">' + params.confirmText + '</button>' : '')
        + ((params.cancel) ? '<button class="btn btn-default" data-confirm="false">' + params.cancelText + '</button>' : '')
    );

    // Убираем событие нажатия
    $confirmModal.off('click', 'button[data-confirm="true"]');
    $confirmModal.off('click', 'button[data-confirm="false"]');

    $confirmModal.on('click', 'button[data-confirm="true"]', function () {
        $confirmModal.modal('hide');
        params.confirmCallback();
    });

    $confirmModal.on('click', 'button[data-confirm="false"]', function () {
        $confirmModal.modal('hide');
        params.cancelCallback();
    });

    $confirmModal.modal('show');
};