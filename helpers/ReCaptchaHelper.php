<?php

namespace rusbeldoor\yii2General\helpers;

use yii;

class ReCaptchaHelper
{
    /**
     * Вывод js для каптчи
     *
     * @return string
     */
    public static function captchaJS()
    { return '<script src="https://www.google.com/recaptcha/api.js?render=' . Yii::$app->params['rusbeldoor']['yii2General']['reCaptcha']['siteKey'] . '"></script>'; }

    /**
     * Проверка каптчи
     *
     * @param array $params
     * @return bool
     */
    public static function check($params = [])
    {
        if (!isset($params['token'])) {
            if (isset($_POST['grecaptcha'])) { $params['token'] = $_POST['grecaptcha']; } else { return false; }
        }

        if (!isset($params['score'])) { $params['score'] = 0.5; }
        if (!isset($params['return'])) { $params['return'] ='boolean'; }

        $attributes = [
            'secret' => Yii::$app->params['rusbeldoor']['yii2General']['reCaptcha']['secretKey'],
            'response' => $params['token'],
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ];
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $attributes);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));

        switch ($params['return']) {
            case 'score': return (($response->success) ? $response->score : 0); break;
            case 'boolean': return (($response->success) ? ($response->score >= $params['score']) : false); break;
            default: return 0;
        }
    }
}