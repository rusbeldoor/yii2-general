<?php

namespace rusbeldoor\yii2General\models;

/**
 * ...
 */
class YandexDirectAPI extends Model
{
    public $url;
    public $login;
    public $token;

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
     * @param string $status
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
     * @param string $state
     * @return string
     */
    static function state($state)
    {
        if (isset(self::$states[$state])) { return self::$states[$state]; }
        return 'Не известен';
    }

    /**
     * Конструктор
     *
     * @param string $url
     * @param string $login
     * @param string $token
     */
    function __construct($url, $login, $token)
    {
        parent::__construct();

        $this->url = $url;
        $this->login = $login;
        $this->token = $token;
    }

    /**
     * Запрос к АПИ
     *
     * @param string $function
     * @param array $params
     * @return mixed
     */
    public function requestAPI($function, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,  $this->url . $function);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' .  $this->token,
            'Client-Login: ' .  $this->login,
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
     * @param string $function
     * @param string $method
     * @param array $params
     * @return mixed
     */
    public function request($function, $method, $params)
    { return $this->requestAPI($function, ['method' => $method, 'params' => $params]); }

    /**
     * Получение компаний
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function getCampaigns($selectionCriteria = [])
    {
        $result = $this->request(
            'campaigns',
            'get',
            [
                'SelectionCriteria' => (object)$selectionCriteria,
                'FieldNames' => ['Id', 'Name', 'Status', 'State'],
            ]
        );
        if (empty($result)) { return []; }
        return $result->Campaigns;
    }

    /**
     * Получение групп объявлений
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function getAdgroups($selectionCriteria = [])
    {
        $result = $this->request(
            'adgroups',
            'get',
            [
                'SelectionCriteria' => (object)$selectionCriteria,
                'FieldNames' => ['Id', 'CampaignId', 'Name', 'Status'],
            ]
        );
        if (empty($result)) { return []; }
        return $result->AdGroups;
    }

    /**
     * Получение объявления
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function getAds($selectionCriteria = [])
    {
        $result = $this->request(
            'ads',
            'get',
            [
                'SelectionCriteria' => (object)$selectionCriteria,
                'FieldNames' => ['Id', 'CampaignId', 'AdGroupId', 'Status', 'State'],
                'TextAdFieldNames' => ['Title', 'Text', 'Href'],
            ]
        );
        if (empty($result)) { return []; }
        return $result->Ads;
    }

    /**
     * Архивация объявлений
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function archiveAds($selectionCriteria = [])
    { return $this->request(
        'ads',
        'archive',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->ArchiveResults; }

    /**
     * Разархивация объявлений
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function unarchiveAds($selectionCriteria = [])
    { return $this->request(
        'ads',
        'unarchive',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->UnarchiveResults; }

    /**
     * Запуск объявлений
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function resumeAds($selectionCriteria = [])
    { return $this->request(
        'ads',
        'resume',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->ResumeResults; }

    /**
     * Остановка объявлений
     *
     * @var array $selectionCriteria
     * @return mixed
     */
    public function suspendAds($selectionCriteria = [])
    { return $this->request(
        'ads',
        'suspend',
        ['SelectionCriteria' => (object)$selectionCriteria]
    )->SuspendResults; }
}
