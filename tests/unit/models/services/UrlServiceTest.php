<?php

namespace tests\unit\models\services;

use app\models\services\UrlService;
use Codeception\Test\Unit;

class UrlServiceTest extends Unit
{
    protected UrlService $urlService;

    protected function _before()
    {
        $this->urlService = new UrlService();
    }

    public function testValidateUrlWithValidUrl()
    {
        $validUrls = [
            'https://google.com',
            'https://example.com/path',
            'https://sub.domain.com',
            'http://localhost:8080',
            'https://example.com/path?param=value'
        ];

        foreach ($validUrls as $url) {
            $this->assertTrue(
                $this->urlService->validateUrl($url),
                "URL '$url' должен быть валидным"
            );
        }
    }

    public function testValidateUrlWithInvalidUrl()
    {
        $invalidUrls = [
            'invalid-url',
            'javascript:alert(1)',
            '',
            'http://',
            'https://'
        ];

        foreach ($invalidUrls as $url) {
            $this->assertFalse(
                $this->urlService->validateUrl($url),
                "URL '$url' должен быть невалидным"
            );
        }
    }

    public function testValidateUrlWithFtpUrl()
    {
        $this->assertTrue($this->urlService->validateUrl('ftp://example.com'));
    }
}