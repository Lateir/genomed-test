<?php

namespace app\models\services;

use app\models\ShortUrl;
use Yii;
use yii\base\Component;

class ShortUrlService extends Component
{
    /**
     * Создает или находит существующую короткую ссылку
     */
    public function createOrFindShortUrl($originalUrl): ?ShortUrl
    {
        $shortUrl = ShortUrl::findOne(['original_url' => $originalUrl]);

        if ($shortUrl !== null) {
            return $shortUrl;
        }

        return $this->createShortUrl($originalUrl);
    }

    /**
     * Создает новую короткую ссылку
     */
    private function createShortUrl($originalUrl): ?ShortUrl
    {
        $shortUrl = new ShortUrl([
            'original_url' => $originalUrl,
            'short_code' => $this->generateShortCode()
        ]);

        return $shortUrl->save() ? $shortUrl : null;
    }

    /**
     * Генерирует уникальный короткий код
     */
    private function generateShortCode(): string
    {
        do {
            $code = Yii::$app->security->generateRandomString(6);
        } while (ShortUrl::findOne(['short_code' => $code]) !== null);

        return $code;
    }

    /**
     * Находит короткую ссылку по коду
     */
    public function findByCode($code): ?ShortUrl
    {
        return ShortUrl::findOne(['short_code' => $code]);
    }
}
