$(document).ready(function () {
    $('.unsubscribe').click(function () {
        confirmDialog({
            text: 'Вы уверены, что хотите отписаться от "' + $(this).data('key-name') + '" (' + $(this).data('channel-name') + ')? <i class="far fa-frown"></i>',
            confirmCallback: () => { $(this).closest('form').submit(); }
        });
    });
    $('.subscribe').click(function () { $(this).closest('form').submit(); });
});