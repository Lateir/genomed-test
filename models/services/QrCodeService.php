<?php

namespace app\models\services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use Yii;
use yii\base\Component;
use yii\helpers\Url;

class QrCodeService extends Component
{
    /**
     * Генерирует QR-код для короткой ссылки
     */
    public function generateQrCode($shortCode): ?string
    {
        try {
            $qrDir = $this->ensureQrDirectory();
            $qrFilePath = $qrDir . "/{$shortCode}.png";

            // Проверяем, существует ли уже файл
            if (file_exists($qrFilePath)) {
                return Url::to("@web/qr/{$shortCode}.png", true);
            }

            $writer = new PngWriter();
            $qr = new QrCode(Url::to(['site/redirect', 'code' => $shortCode], true));
            $result = $writer->write($qr);
            $result->saveToFile($qrFilePath);

            return Url::to("@web/qr/{$shortCode}.png", true);
        } catch (Exception $e) {
            Yii::error("Ошибка создания QR кода: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Создает директорию для QR-кодов если она не существует
     */
    private function ensureQrDirectory(): string
    {
        $qrDir = Yii::getAlias('@webroot/qr');
        if (!is_dir($qrDir)) {
            mkdir($qrDir, 0755, true);
        }
        return $qrDir;
    }
}
