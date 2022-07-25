<?php

namespace rusbeldoor\yii2General\helpers;

class CurlHelper
{
    /** Запрос */
    private static function request(string $type, array $params = []): array
    {
        $ch = curl_init($params['url']);

        // Определяем тип запроса
        switch ($type) {
            case 'get': curl_setopt($ch, CURLOPT_POST, false); break;
            case 'post': curl_setopt($ch, CURLOPT_POST, true); break;
            case 'put': curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); break;
            case 'delete': curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); break;
            default: curl_close($ch); return ['status' => 'error', 'data' => 'Указан не реализованный тип запроса.'];
        }

        // Параметры по умолчанию
        // true для следования любому заголовку "Location: ", отправленному сервером в своём ответе. Смотрите также CURLOPT_MAXREDIRS.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Выводить заголовки в результате
        curl_setopt($ch, CURLOPT_HEADER, false);

        // Опциональные параметры
        if (isset($params['headers'])) { curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']); } // Параметры заголовка
        if (isset($params['fields'])) { curl_setopt($ch, CURLOPT_POSTFIELDS, $params['fields']); } // Параметры для запроса
        if (isset($params['ssl_verifypeer'])) { curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $params['ssl_verifypeer']); }
        if (isset($params['referer'])) { curl_setopt($ch, CURLOPT_REFERER, $params['referer']); }

        $result = curl_exec($ch);

        // Логирование результата (в консоль и файл)
        //echo 'url: '; print_r($params['url']); echo "\r\n";
        //if (isset($params['headers'])) { echo 'headers: '; print_r($params['headers']); echo "\r\n"; }
        //if (isset($params['fields'])) { echo 'fields: '; print_r($params['fields']); echo "\r\n"; }
        //echo 'curlInfo: '; print_r(curl_getinfo($ch)); echo "\r\n";
        //echo 'curlError: '; print_r(curl_error($ch)); echo "\r\n";
        //echo 'result: '; print_r($result); echo "\r\n";
        //AppHelper::log('curl', 'url: ' . $params['url']);
        //if (isset($params['headers'])) { AppHelper::log('curl', 'headers: ' . print_r($params['headers'], true)); }
        //if (isset($params['fields'])) { AppHelper::log('curl', 'fields: ' . print_r($params['fields'], true)); }
        //AppHelper::log('curl', 'curlInfo: ' . print_r(curl_getinfo($ch), true));
        //AppHelper::log('curl', 'curlError: ' . print_r(curl_error($ch), true));
        //AppHelper::log('curl', 'result: ' . print_r($result, true));

        if ($result === false) { $result = ['status' => 'error', 'data' => curl_error($ch), 'dataOriginal' => curl_error($ch)]; }
        else { $result = ['status' => 'success', 'data' => @json_decode($result, true), 'dataOriginal' => $result]; }

        curl_close($ch);

        return $result;
    }

    /** Запрос get */
    public static function get(array $params = []): array
    { return self::request('get', $params); }

    /** Запрос post */
    public static function post(array $params = []): array
    { return self::request('post', $params); }

    /** Запрос put */
    public static function put(array $params = []): array
    { return self::request('put', $params); }

    /** Запрос delete */
    public static function delete(array $params = []): array
    { return self::request('delete', $params); }
}