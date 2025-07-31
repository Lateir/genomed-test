<?php

namespace tests\unit\models\services;

use app\models\services\UrlShortenerService;
use app\models\services\UrlService;
use app\models\services\ShortUrlService;
use Codeception\Test\Unit;
use Codeception\Stub;

class UrlShortenerServiceTest extends Unit
{
    protected UrlShortenerService $urlShortenerService;

    protected function _before()
    {
        $this->urlShortenerService = new UrlShortenerService();
    }

    public function testShortenUrlWithInvalidUrl()
    {
        // Создаем mock для UrlService
        $urlServiceMock = Stub::make(UrlService::class, [
            'validateUrl' => false
        ]);

        $this->urlShortenerService->urlService = $urlServiceMock;

        $result = $this->urlShortenerService->shortenUrl('invalid-url');

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Невалидный URL', $result['error']);
    }

    public function testShortenUrlWithUnavailableUrl()
    {
        $urlServiceMock = Stub::make(UrlService::class, [
            'validateUrl' => true,
            'checkUrlAvailable' => false
        ]);

        $this->urlShortenerService->urlService = $urlServiceMock;

        $result = $this->urlShortenerService->shortenUrl('https://example.com');

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('URL недоступен', $result['error']);
    }

    public function testProcessRedirectNotFound()
    {
        $shortUrlServiceMock = Stub::make(ShortUrlService::class, [
            'findByCode' => null
        ]);

        $this->urlShortenerService->shortUrlService = $shortUrlServiceMock;

        $result = $this->urlShortenerService->processRedirect('nonexistent');

        $this->assertNull($result);
    }

    public function testServiceInitialization()
    {
        $service = new UrlShortenerService();
        $this->assertInstanceOf(UrlShortenerService::class, $service);
    }
}