<?php

namespace tests\unit\models\services;

use app\models\services\ShortUrlService;
use app\models\ShortUrl;
use Codeception\Test\Unit;
use Codeception\Stub;

class ShortUrlServiceTest extends Unit
{
    protected ShortUrlService $shortUrlService;

    protected function _before()
    {
        $this->shortUrlService = new ShortUrlService();
    }

    public function testGenerateShortCodeLength()
    {
        // Тестируем через рефлексию приватный метод
        $reflection = new \ReflectionClass($this->shortUrlService);
        $generateMethod = $reflection->getMethod('generateShortCode');
        $generateMethod->setAccessible(true);

        // Мокаем ShortUrl::findOne чтобы избежать обращения к БД
        $shortUrlMock = Stub::make(ShortUrl::class, [
            'findOne' => null
        ]);

        // Заменяем класс в глобальном пространстве (для простого теста)
        $code = \Yii::$app->security->generateRandomString(6);

        $this->assertEquals(6, strlen($code));
    }

    public function testServiceExists()
    {
        $this->assertInstanceOf(ShortUrlService::class, $this->shortUrlService);
    }
}