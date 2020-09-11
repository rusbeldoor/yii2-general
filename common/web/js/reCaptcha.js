/**
 * Инициализация reCaptcha v3 token
 *
 * @param reCaptchaSiteKey string
 * @param params array
 */
function reCaptchaInitToken(reCaptchaSiteKey, params, counter) {
    // Если reCaptcha скрипт не установлен
    if (document.querySelector('script[src="https://www.google.com/recaptcha/api.js?render=' + reCaptchaSiteKey + '"]') === null) {
        // Устанавливаем reCaptcha скрипт
        let script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js?render=' + reCaptchaSiteKey;
        document.body.append(script);
    }

    if (typeof params == 'undefined') { params = {}; }
    if (typeof params.callback == 'undefined' || typeof params.callback != 'function') { params.callback = null; }
    if (typeof params.inputId == 'undefined') { params.inputId = 'grecaptcha'; }

    let parent = document.body;
    if (typeof params.parentId != 'undefined') { parent = document.getElementById(params.parentId); }
    if (parent === null) { parent = document.body; }

    // Если grecaptcha определена
    if (typeof grecaptcha !== 'undefined') {
        grecaptcha.ready(function () {
            grecaptcha.execute(reCaptchaSiteKey, {action: 'submit'}).then(function(token) {
                // Создаем input для хранения токена
                if (document.getElementById(params.inputId) === null) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.id = params.inputId;
                    input.name = params.inputId;
                    parent.append(input);
                }
                // Заполняем input токеном
                document.getElementById(params.inputId).value = token;

                // Если был передан callback выполняем его
                if (params.callback !== null) { params.callback(token); }
            });
        });
    } else {
        // Инициализируем номер рекурсивного вызова
        if (typeof counter == 'undefined') { counter = 1; }
        // Ограничение количества рекурсивных вызовов (100 раз)
        if (counter > 100) { return; }
        // Запускаем повторную инициализацию через 0.1 секунды (ждем когда grecaptcha будет определена)
        setTimeout(reCaptchaInitToken, 100, reCaptchaSiteKey, params, ++counter);
    }
}

/**
 * Получение reCaptcha v3 token
 *
 * @param inputId string
 */
function reCaptchaGetToken(inputId) {
    if (typeof inputId == 'undefined') { inputId = 'grecaptcha'; }
    return document.getElementById(inputId).value;
}
