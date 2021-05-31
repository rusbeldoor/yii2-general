<?php

namespace rusbeldoor\yii2General\helpers;

use yii;
use yii\web\ForbiddenHttpException;

class AppHelper
{
    const PLATFORM_ID = 1;
    const PLATFORM_ALIAS = 'quick-service';

    /*****************************************
     *** *** *** Завершение работы *** *** ***
     *****************************************/

    /**
     * Завершение, если не ajax запрос
     *
     * @return void
     */
    public static function exitIfNotAjaxRequest()
    { if (!Yii::$app->request->isAjax) { exit; } }

    /**
     * Завершение, если не post запрос
     *
     * @return void
     */
    public static function exitIfNotPostRequest()
    { if (!Yii::$app->request->isPost) { exit; } }

    /**
     * Завершение с выводом
     *
     * @param string $string
     * @return void
     */
    public static function exitWithEcho($string)
    { echo $string; exit; }

    /**
     * Завершение с выводом сообщения
     *
     * @param string $type
     * @param string $text
     * @param bool $close
     * @return void
     */
    public static function exitWithEchoMessage($type, $text, $close = false)
    { self::exitWithEcho(AlertHelper::alert($type, $text, $close)); }

    /**
     * Завершение с выводом json
     *
     * @param array $data
     * @return void
     */
    public static function exitWithJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Завершение с выводом json ['result' => $result, 'data' => $data]
     *
     * @param mixed $result
     * @param mixed $data
     * @return void
     */
    public static function exitWithJsonResultData($result, $data = null)
    {
        $array = [];
        $array['result'] = $result;
        if ($data) { $array['data'] = $data; }
        self::exitWithJson($array);
    }

    /**
     * Завершение с выводом json ['result' => $result]
     *
     * @param mixed $result
     * @return void
     */
    public static function exitWithJsonResult($result)
    { self::exitWithJsonResultData($result); }

    /*************************************
     *** *** *** Права доступа *** *** ***
     *************************************/

    /**
     * Проверка права доступа
     *
     * @param string $itemName
     */
    public static function forbiddenExceptionIfNotHavePermission($itemName)
    {
        if (!Yii::$app->user->can($itemName)) {
            throw new ForbiddenHttpException('Доступ запрещён.');
        }
    }

    /*******************************
     *** *** *** Flashes *** *** ***
     *******************************/

    /**
     * Установка сообщений
     *
     * @param array $flashs
     * @return void
     */
    public static function setFlashes($flashs)
    {
        foreach($flashs as $key => $text) {
            Yii::$app->session->setFlash($key, $text);
        }
    }

    /**
     * ...
     *
     * @param string $url
     * @param string $flashType
     * @param string $flashText
     * @return object
     */
    public static function redirectWithFlash($url, $flashType, $flashText)
    {
        self::setFlashes([$flashType => $flashText]);
        return Yii::$app->controller->redirect($url);
    }

    /**
     * ...
     *
     * @param string $url
     * @param array $flashes
     * @return void
     */
    public static function redirectWithFlashes($url, $flashes)
    {
        foreach ($flashes as $flash) { self::setFlashes([$flash['type'] => $flash['text']]); }
        return Yii::$app->controller->redirect($url);
    }

    /**
     * ...
     *
     * @param string $flashType
     * @param string $flashText
     * @return void
     */
    public static function redirectIndexWithFlash($flashType, $flashText)
    { self::redirectWithFlash(['index'], $flashType, $flashText); }

    /**
     * ...
     *
     * @param array $flashes
     * @return void
     */
    public static function redirectIndexWithFlashes($flashes)
    { self::redirectWithFlashes(['index'], $flashes); }

    /****************************************
     *** *** *** Работа с файлами *** *** ***
     ****************************************/

    /**
     * Логирование данных в файл
     *
     * @param string $file
     * @param string $string
     * @return void
     */
    public static function log($file, $string, $n = true)
    {
        $filename = '@runtime/' . $file . '.log';
        @error_log('[' . date('H:i:s d.m.Y') . ']    ' . $string . ($n ? "\n" : ''), 3, $filename);
        @chmod($filename, 0777);
    }
}