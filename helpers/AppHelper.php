<?php

namespace rusbeldoor\yii2General\helpers;

use yii;
use yii\web\ForbiddenHttpException;

class AppHelper
{
    // Режимы работы
    const PRODUCTION_MODE = 0;
    const DEVELOP_MODE = 1;
    const LOCAL_MODE = 2;

    // Типы оповещений
    const ALERT_SUCCESS = 'success';
    const ALERT_ERROR = 'danger';
    const ALERT_WARNING = 'warning';
    const ALERT_INFO = 'info';

    // Типы результатов
    const RESULT_SUCCESS = 'success';
    const RESULT_ERROR = 'error';
    const RESULT_NOTHING = 'nothing ';

    /*** Режим работы ***/

    /** Если production режим работы */
    public static function isProduction(): bool
    { return (Yii::$app->params['mode'] === self::PRODUCTION_MODE); }

    /** Если develop режим работы */
    public static function isDevelop(): bool
    { return (Yii::$app->params['mode'] === self::DEVELOP_MODE); }

    /** Если local режим работы */
    public static function isLocal(): bool
    { return (Yii::$app->params['mode'] === self::LOCAL_MODE); }

    /*** Завершение работы ***/

    /** Завершение, если не ajax запрос */
    public static function exitIfNotAjaxRequest(): void
    { if (!Yii::$app->request->isAjax) { exit; } }

    /** Завершение, если не post запрос */
    public static function exitIfNotPostRequest() : void
    { if (!Yii::$app->request->isPost) { exit; } }

    /** Завершение, если не ajax и не post запрос*/
    public static function exitIfNotAjaxAndPostRequest(): void
    { self::exitIfNotAjaxRequest(); self::exitIfNotPostRequest(); }

    /** Завершение, если пользователь не авторизован */
    public static function exitIfUserGuest(): void
    { if (Yii::$app->user->isGuest) { exit; } }

    /** Завершение с выводом */
    public static function exitWithEcho(int|float|string $text): void
    { echo $text; exit; }

    /** Завершение с выводом сообщения*/
    public static function exitWithEchoMessage(string $type, string $text, bool $close = false): void
    { self::exitWithEcho(HtmlHelper::alert($type, $text, $close)); }

    /** Завершение с выводом json */
    public static function exitWithJson(array $data): void
    { header('Content-Type: application/json'); echo json_encode($data); exit; }

    /** Завершение с выводом json ['result' => $result, 'data' => $data] */
    public static function exitWithJsonResultData(int|string $result, mixed $data = null): void
    {
        $array = ['result' => $result];
        if ($data) { $array['data'] = $data; }
        self::exitWithJson($array);
    }

    /** Завершение с выводом json ['result' => $result] */
    public static function exitWithJsonResult(int|string $result)
    { self::exitWithJsonResultData($result); }

    /** Завершение с выводом json ['result' => 'success', 'data' => $data]*/
    public static function exitWithJsonResultSuccessData($data = null)
    { self::exitWithJsonResultData('success', $data); }

    /**
     * Завершение с выводом json ['result' => 'success', 'data' => ['alerts' => $alerts]]
     *
     * @param array $alerts
     * @return void
     */
    public static function exitWithJsonResultSuccessDataAlerts(array $alerts = [])
    { self::exitWithJsonResultSuccessData(['alerts' => $alerts]); }

    /**
     * Завершение с выводом json ['result' => 'success', 'data' => ['html' => $html]]
     *
     * @param string $html
     * @return void
     */
    public static function exitWithJsonResultSuccessDataHtml(string $html = '')
    { self::exitWithJsonResultSuccessData(['html' => $html]); }

    /**
     * Завершение с выводом json ['result' => 'error', 'data' => $data]
     *
     * @param mixed $data
     * @return void
     */
    public static function exitWithJsonResultErrorData($data = null)
    { self::exitWithJsonResultData('error', $data); }

    /**
     * Завершение с выводом json ['result' => 'error', 'data' => ['alerts' => $alerts]]
     *
     * @param array $alerts
     * @return void
     */
    public static function exitWithJsonResultErrorDataAlerts(array $alerts = [])
    { self::exitWithJsonResultErrorData(['alerts' => $alerts]); }


    /*** Права доступа ***/

    /**
     * Проверка права доступа
     *
     * @param string $itemName
     */
    public static function forbiddenExceptionIfNotHavePermission(string $itemName)
    { if (!Yii::$app->user->can($itemName)) { throw new ForbiddenHttpException('Доступ запрещён.'); } }

    /*** Flashes ***/

    /**
     * Установка сообщений
     *
     * @param array $flashs
     * @return void
     */
    public static function setFlashes(array $flashs)
    { foreach($flashs as $key => $text) { Yii::$app->session->setFlash($key, $text); } }

    /*** Перенаправления ***/

    /**
     * ...
     *
     * @param string|array $url
     * @return object
     */
    public static function redirect(string|array $url)
    { return Yii::$app->controller->redirect($url); }

    /**
     * ...
     *
     * @param string|array $url
     * @param string $flashType
     * @param string $flashText
     * @return object
     */
    public static function redirectWithFlash(string|array $url, string $flashType, string $flashText)
    {
        self::setFlashes([$flashType => $flashText]);
        return self::redirect($url);
    }

    /**
     * ...
     *
     * @param string|array $url
     * @param array $flashes
     * @return void
     */
    public static function redirectWithFlashes(string|array $url, array $flashes)
    {
        foreach ($flashes as $flash) { self::setFlashes([$flash['type'] => $flash['text']]); }
        return self::redirect($url);
    }

    /**
     * ...
     *
     * @param string $flashType
     * @param string $flashText
     * @return void
     */
    public static function redirectIndexWithFlash(string $flashType, string $flashText)
    { return self::redirectWithFlash(['index'], $flashType, $flashText); }

    /**
     * ...
     *
     * @param array $flashes
     * @return void
     */
    public static function redirectIndexWithFlashes(array $flashes)
    { return self::redirectWithFlashes(['index'], $flashes); }

    /*** Работа с файлами ***/

    /**
     * Логирование данных в файл
     *
     * @param string $file
     * @param string $string
     * @param bool $n
     * @return void
     */
    public static function log(string $file, string $string, bool $n = true)
    {
        $filename = '@runtime/' . $file . '.log';
        @error_log('[' . date('H:i:s d.m.Y') . ']    ' . $string . (($n) ? "\n" : ''), 3, $filename);
        @chmod($filename, 0777);
    }
}