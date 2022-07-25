<?php

namespace rusbeldoor\yii2General\helpers;

use yii;
use yii\web\Response;
use yii\web\View;

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
    public static function exitWithJsonResult(int|string $result): void
    { self::exitWithJsonResultData($result); }

    /** Завершение с выводом json ['result' => 'success', 'data' => $data]*/
    public static function exitWithJsonResultSuccessData(mixed $data = null): void
    { self::exitWithJsonResultData('success', $data); }

    /** Завершение с выводом json ['result' => 'success', 'data' => ['alerts' => $alerts]] */
    public static function exitWithJsonResultSuccessDataAlerts(array $alerts = []): void
    { self::exitWithJsonResultSuccessData(['alerts' => $alerts]); }

    /** Завершение с выводом json ['result' => 'success', 'data' => ['html' => $html]] */
    public static function exitWithJsonResultSuccessDataHtml(string $html = ''): void
    { self::exitWithJsonResultSuccessData(['html' => $html]); }

    /** Завершение с выводом json ['result' => 'error', 'data' => $data] */
    public static function exitWithJsonResultErrorData(mixed $data = null): void
    { self::exitWithJsonResultData('error', $data); }

    /** Завершение с выводом json ['result' => 'error', 'data' => ['alerts' => $alerts]] */
    public static function exitWithJsonResultErrorDataAlerts(array $alerts = []): void
    { self::exitWithJsonResultErrorData(['alerts' => $alerts]); }

    /** Завершение с выводом json ['result' => 'error', 'data' => ['html' => $html]] */
    public static function exitWithJsonResultErrorDataHtml(string $html = ''): void
    { self::exitWithJsonResultErrorData(['html' => $html]); }

    /*** Flashes ***/

    /** Задание flashes */
    public static function setFlashes(array $flashs): void
    { foreach($flashs as $type => $text) { Yii::$app->session->setFlash($type, $text); } }

    /*** Перенаправления ***/

    /** Перенаправление */
    public static function redirect(string|array $url): Response
    { return Yii::$app->controller->redirect($url); }

    /** ... */
    public static function redirectWithFlash(string|array $url, string $flashType, string $flashText): void
    {
        self::setFlashes([$flashType => $flashText]);
        self::redirect($url);
    }

    /** ... */
    public static function redirectWithFlashes(string|array $url, array $flashes): void
    {
        foreach ($flashes as $flash) { self::setFlashes([$flash['type'] => $flash['text']]); }
        self::redirect($url);
    }

    /** ... */
    public static function redirectIndexWithFlash(string $flashType, string $flashText): void
    { self::redirectWithFlash(['index'], $flashType, $flashText); }

    /** ... */
    public static function redirectIndexWithFlashes(array $flashes): void
    { self::redirectWithFlashes(['index'], $flashes); }

    /*** CSS ***/

    /** Регистарция css файлов */
    public static function registerCssFile(View $view, string $path, array $options = [], string $key): void
    {
        //$view->registerCss($path . ((self::isLocal()) ? '.css' : '.min.css') . '?v=' . Yii::$app->params['projectVersion'], $options, $key);
        $view->registerCssFile($path . '.css' . '?v=' . Yii::$app->params['projectVersion'], $options, $key);
    }

    /*** JS ***/

    /** Регистарция js файлов */
    public static function registerScriptFile(View $view, string $path, array $options = [], string $key): void
    {
        //$view->registerScriptFile($path . ((self::isLocal()) ? '.js' : '.min.js') . '?v=' . Yii::$app->params['projectVersion'], $options, $key);
        $view->registerJSFile($path . '.js' . '?v=' . Yii::$app->params['projectVersion'], $options, $key);
    }

    /*** Логи ***/

    /** Логирование данных в файл*/
    public static function log(string $file, string $string, bool $n = true): void
    {
        $filename = '@runtime/' . $file . '.log';
        @error_log('[' . date('H:i:s d.m.Y') . ']    ' . $string . (($n) ? "\n" : ''), 3, $filename);
        @chmod($filename, 0777);
    }

    /*** Запросы ***/

    /** ... */
    public static function getRequestHeaders(): array|bool
    {
        if (!function_exists('getallheaders')) {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        } else { return getallheaders(); }
    }

    /*** Другое ***/

    /** ... */
    public static function getGUID(): string
    {
        mt_srand((double)microtime() * 10000);
        $charId = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        return
            substr($charId, 0, 8) . $hyphen
            . substr($charId, 8, 4) . $hyphen
            . substr($charId, 12, 4) . $hyphen
            . substr($charId, 16, 4) . $hyphen
            . substr($charId, 20, 12);
    }
}