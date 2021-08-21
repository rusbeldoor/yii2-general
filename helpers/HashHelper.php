<?php

namespace rusbeldoor\yii2General\helpers;

class HashHelper
{
    /**
     * Хэш
     *
     * Например:
     *
     * sha256(sha256('строка с данными') . 'соль')
     *
     * @param string $data
     * @param string $salt
     * @param string $algo
     * @return string
     */
    public static function hash($data, $salt, $algo = 'sha256')
    {
        if (is_array($data)) { $data = implode(';', $data); }
        if (!is_string($data)) { $data = (string)$data; }
        return hash($algo, hash($algo, $data) . $salt);
    }
}