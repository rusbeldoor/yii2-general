<?php

namespace rusbeldoor\yii2General\helpers;

use yii;

class YandexDirectApiHelper
{
    // Статусы
    static $statuses = [
        'DRAFT' => 'Черновик',
        'MODERATION' => 'На модерации',
        'ACCEPTED' => 'Модерация прошла, но не до конца',
        'REJECTED' => 'Модерация прошла',
    ];

    // Состояния
    static $states = [
        'ARCHIVED' => 'Архив',
        'SUSPENDED' => 'Приостановлена',
        'ENDED' => 'Закончена',
        'ON' => 'Работает',
        'OFF' => 'Не работает',
    ];

    /**
     * Статус
     *
     * @param $status string
     * @return string
     */
    static function status($status)
    {
        if (isset(self::$statuses[$status])) { return self::$statuses[$status]; }
        return 'Не известен';
    }

    /**
     * Состояние
     *
     * @param $state string
     * @return string
     */
    static function state($state)
    {
        if (isset(self::$states[$state])) { return self::$states[$state]; }
        return 'Не известен';
    }

    /**
     * Запрос к АПИ
     *
     * @param $function string
     * @param $params array
     * @return mixed
     */
    static function requestAPI($function, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,  Yii::$app->params['rusbeldoor']['yii2YandexDirect']['api']['url'] . $function);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' .  Yii::$app->params['rusbeldoor']['yii2YandexDirect']['api']['token'],
            'Client-Login: ' .  Yii::$app->params['rusbeldoor']['yii2YandexDirect']['api']['login'],
            'Accept-Language: ru',
            'Content-Type: application/json; charset=utf-8',
        ]);
        $response = curl_exec($curl);
        if (!$response) { return null; }
        $responseHeadersSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $responseHeaders = substr($response, 0, $responseHeadersSize);
        $responseBody = substr($response, $responseHeadersSize);
        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200) { return null; }
        $responseBody = json_decode($responseBody);
        if (isset($responseBody->error)) { return null; }
        curl_close($curl);
        return $responseBody->result;
    }

    /**
     * Запрос
     *
     * @param $function string
     * @param $method string
     * @param $params
     * @return mixed
     */
    static function request($function, $method, $params)
    { return self::requestAPI($function, ['method' => $method, 'params' => $params]); }

    /**
     * Компании
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function getCampaigns($selectionCriteria = [])
    { return static::request(
        'campaigns',
        'get',
        [
            'SelectionCriteria' => (object)$selectionCriteria,
            'FieldNames' => ['Id', 'Name', 'Status', 'State'],
        ]
    )->Campaigns; }

    /**
     * Группы объявлений
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function getAdgroups($selectionCriteria = [])
    { return static::request(
        'adgroups',
        'get',
        [
            'SelectionCriteria' => (object)$selectionCriteria,
            'FieldNames' => ['Id', 'CampaignId', 'Name', 'Status'],
        ]
    )->AdGroups; }

    /**
     * Объявления
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function getAds($selectionCriteria = [])
    { return static::request(
        'ads',
        'get',
        [
            'SelectionCriteria' => (object)$selectionCriteria,
            'FieldNames' => ['Id', 'CampaignId', 'AdGroupId', 'Status', 'State'],
            'TextAdFieldNames' => ['Title', 'Text', 'Href'],
        ]
    )->Ads; }

    /**
     * Архивация объявлений
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function archiveAds($selectionCriteria = [])
    { return static::request(
        'ads',
        'archive',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->ArchiveResults; }

    /**
     * Разархивация объявлений
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function unarchiveAds($selectionCriteria = [])
    { return static::request(
        'ads',
        'unarchive',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->UnarchiveResults; }

    /**
     * Запуск объявлений
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function resumeAds($selectionCriteria = [])
    { return static::request(
        'ads',
        'resume',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->ResumeResults; }

    /**
     * Остановка объявлений
     *
     * @var $selectionCriteria array
     * @return mixed
     */
    static function suspendAds($selectionCriteria = [])
    { return static::request(
        'ads',
        'suspend',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->SuspendResults; }
}
