<?php

namespace app\models\services;

use app\models\ShortUrl;
use yii\base\Component;
use yii\helpers\Url;

class UrlShortenerService extends Component
{
    public $urlService;
    public $shortUrlService;
    public $qrCodeService;
    public $clickLogService;

    public function init()
    {
        parent::init();

        $this->urlService = new UrlService();
        $this->shortUrlService = new ShortUrlService();
        $this->qrCodeService = new QrCodeService();
        $this->clickLogService = new ClickLogService();
    }

    /**
     * Создает короткую ссылку с QR-кодом
     */
    public function shortenUrl($originalUrl): array
    {
        // Валидация URL
        if (!$this->urlService->validateUrl($originalUrl)) {
            return ['error' => 'Невалидный URL'];
        }

        // Проверка доступности URL
        if (!$this->urlService->checkUrlAvailable($originalUrl)) {
            return ['error' => 'URL недоступен'];
        }

        // Создание или поиск короткой ссылки
        $shortUrl = $this->shortUrlService->createOrFindShortUrl($originalUrl);
        if ($shortUrl === null) {
            return ['error' => 'Ошибка при сохранении'];
        }

        // Генерация QR-кода
        $qrCodeUrl = $this->qrCodeService->generateQrCode($shortUrl->short_code);
        if ($qrCodeUrl === null) {
            return ['error' => 'Ошибка создания QR кода'];
        }

        return [
            'shortUrl' => Url::to(['site/redirect', 'code' => $shortUrl->short_code], true),
            'qr' => $qrCodeUrl,
        ];
    }

    /**
     * Обрабатывает переход по короткой ссылке
     */
    public function processRedirect($code): ?ShortUrl
    {
        $shortUrl = $this->shortUrlService->findByCode($code);
        if ($shortUrl === null) {
            return null;
        }

        $this->clickLogService->logClick($shortUrl);
        return $shortUrl;
    }
}
