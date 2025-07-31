<?php

namespace app\models\services;

use yii\base\Component;

class UrlService extends Component
{
    /**
     * Проверяет валидность URL
     */
    public function validateUrl($url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Проверяет доступность URL
     */
    public function checkUrlAvailable($url): bool
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }
}
