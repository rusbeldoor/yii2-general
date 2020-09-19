/*************************************
 *** *** *** Инициализация *** *** ***
 *************************************/

//$.datetimepicker.setLocale('ru');

/*********************************
 *** *** *** Интерфейс *** *** ***
 *********************************/

$(document).ready(function() {
    $('.panelSearchFormToggle').click(function () {
        $('.panelSearchFormContainer').toggle();
        return false;
    });
});