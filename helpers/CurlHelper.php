<?php

namespace rusbeldoor\yii2General\helpers;

class CurlHelper
{
    /**
     * Запрос
     *
     * @param string $type
     * @param array $params
     * @return bool|mixed
     */
    private static function request($type, $params = [])
    {
        $ch = curl_init($params['url']);

        curl_setopt($ch, CURLOPT_HEADER, false); // Выводить заголовки в результате
        if (isset($params['headers'])) { curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']); } // Параметры заголовка
        if (isset($params['fields'])) { curl_setopt($ch, CURLOPT_POSTFIELDS, ((is_array($params['fields'])) ? json_encode($params['fields']) : $params['fields'])); } // Параметры для запроса
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Необходимость возвращать результат

        switch ($type) {
            case 'get': curl_setopt($ch, CURLOPT_POST, false); break;
            case 'post': curl_setopt($ch, CURLOPT_POST, true); break;
            case 'put': curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); break;
            default: false;
        }

        $result = curl_exec($ch);

        curl_close($ch);

        if ($result === false) { return false; }

        return @json_decode($result,true);
    }

    /**
     * Запрос get
     *
     * @param array $params
     * @return bool|array
     */
    public static function get($params = []) { return self::request('get', $params); }

    /**
     * Запрос post
     *
     * @param array $params
     * @return bool|mixed
     */
    public static function post($params = []) { return self::request('post', $params); }

    /**
     * Запрос put
     *
     * @param array $params
     * @return bool|mixed
     */
    public static function put($params = []) { return self::request('put', $params); }
}