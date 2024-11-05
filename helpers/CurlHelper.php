<?php

namespace rusbeldoor\yii2General\helpers;

class CurlHelper
{
    /** Запрос */
    private static function request(string $type, array $params = [], int $maxAttemptsCount = 1): array
    {
        $time = time();

        $error = $answer = null;

        // Пробуем сделать запрос $attemptsCount раз
        for ($lastAttemptNumber = 1; $lastAttemptNumber <= $maxAttemptsCount; $lastAttemptNumber++) {
            // Если не первая попытка сделать запрос, ждём 1 секунду
            if ($lastAttemptNumber > 1) { usleep(1000000); }

            // Инициализируем curl
            $ch = curl_init($params['url']);

            // Определяем тип запроса
            switch ($type) {
                case 'get':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_POST, false);
                    break;

                case 'post': curl_setopt($ch, CURLOPT_POST, true); break;
                case 'put': curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); break;
                case 'delete': curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); break;
                case 'patch': curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); break;

                default:
                    $error = 'Указан не реализованный тип запроса.';
                    $answer = false;
                    curl_close($ch);
                    break 2;
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
            if (isset($params['sslVerifypeer'])) { curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $params['sslVerifypeer']); }
            if (isset($params['referer'])) { curl_setopt($ch, CURLOPT_REFERER, $params['referer']); }
            if (isset($params['connectionTimeout'])) { curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $params['connectionTimeout']); }
            if (isset($params['timeout'])) { curl_setopt($ch, CURLOPT_TIMEOUT, $params['connectionTimeout']); }

            // Выполняем curl запрос
            $answer = curl_exec($ch);

            // Получаем ошибки по curl запросу
            $error = curl_error($ch);

            // Если запрос прошёл успешно, останавливаем попытки
            if (($answer !== false) && empty($error)) { break; }

            curl_close($ch);
        }

        return [
            'requestCurl' => CurlHelper::string($type, $params),
            'requestParams' => [
                'sslVerifypeer' => $params['sslVerifypeer'] ?? null,
                'connectionTimeout' => $params['connectionTimeout'] ?? null,
                'timeout' => $params['timeout'] ?? null,
            ],
            'status' => (($answer !== false) ? 'success' : 'error'),
            'data' => (($answer !== false) ? @json_decode($answer, true) : $error),
            'dataOriginal' => $answer,
            'statistic' => [
                'lastAttemptNumber' => $lastAttemptNumber,
                'executionTime' => (time() - $time) . 's',
            ],
        ];
    }

    /** Запрос get */
    public static function get(array $params = [], int $attemptsNumber = 1): array
    { return self::request('get', $params, $attemptsNumber); }

    /** Запрос post */
    public static function post(array $params = [], int $attemptsNumber = 1): array
    { return self::request('post', $params, $attemptsNumber); }

    /** Запрос put */
    public static function put(array $params = [], int $attemptsNumber = 1): array
    { return self::request('put', $params, $attemptsNumber); }

    /** Запрос delete */
    public static function delete(array $params = [], int $attemptsNumber = 1): array
    { return self::request('delete', $params, $attemptsNumber); }

    /** Запрос patch */
    public static function patch(array $params = [], int $attemptsNumber = 1): array
    { return self::request('patch', $params, $attemptsNumber); }

    /** Запрос в виде строки */
    public static function string(string $type, array $params, array $replacements = []): string
    {
        $headers = '';
        if (
            isset($params['headers'])
            && is_array($params['headers'])
        ) {
            foreach ($params['headers'] as $header) { $headers .= ' -H \'' . $header . '\''; }
        }

        $fields = '';
        if (isset($params['fields'])) {
            if (is_string($params['fields'])) {
                $fields = ' --data \'' . $params['fields'] . '\'';
            } elseif (is_array($params['fields'])) {
                $fields = ' --data \'' . json_encode($params['fields']) . '\'';
            }
        }

        $result =
            'curl'
            . ' -X ' . mb_strtoupper($type)
            . ' -k'
            . ' -i \'' . $params['url'] . '\''
            . $headers
            . $fields;

        // Перебираем замены
        foreach ($replacements as $search => $replacement) {
            // Производим замены
            $result = StringHelper::mbStrReplace($search, $replacement, $result);
        }

        return $result;
    }
}
