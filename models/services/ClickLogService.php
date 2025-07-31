<?php

namespace app\models\services;

use app\models\ShortUrl;
use app\models\UrlClickLog;
use Yii;
use yii\base\Component;

class ClickLogService extends Component
{
    /**
     * Логирует клик по короткой ссылке
     */
    public function logClick(ShortUrl $shortUrl): void
    {
        // Увеличиваем счетчик кликов
        $shortUrl->updateCounters(['clicks' => 1]);

        // Создаем запись в логе
        $log = new UrlClickLog([
            'short_url_id' => $shortUrl->id,
            'ip_address' => Yii::$app->request->userIP
        ]);
        $log->save(false);
    }
}
