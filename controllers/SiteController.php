<?php

namespace app\controllers;

use app\models\ShortUrl;
use app\models\UrlClickLog;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionShorten()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $url = Yii::$app->request->post('url');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return ['error' => 'Невалидный URL'];
        }

        if (!$this->checkUrlAvailable($url)) {
            return ['error' => 'URL недоступен'];
        }

        $short = ShortUrl::findOne(['original_url' => $url]) ?? new ShortUrl([
            'original_url' => $url,
            'short_code' => Yii::$app->security->generateRandomString(6)
        ]);

        if ($short->isNewRecord && !$short->save()) {
            return ['error' => 'Ошибка при сохранении'];
        }

        try {
            // Создаем директорию если не существует
            $qrDir = Yii::getAlias('@webroot/qr');
            if (!is_dir($qrDir)) {
                mkdir($qrDir, 0755, true);
            }

            $writer = new PngWriter();

            $qr = new QrCode(Url::to(['site/redirect', 'code' => $short->short_code], true));
            $resultPng = $writer->write($qr);

            $resultPng->saveToFile($qrDir . "/{$short->short_code}.png");

            return [
                'shortUrl' => Url::to(['site/redirect', 'code' => $short->short_code], true),
                'qr' => Url::to("@web/qr/{$short->short_code}.png", true),
            ];
        } catch (Exception $e) {
            Yii::error("Ошибка создания QR кода: " . $e->getMessage());
            return ['error' => 'Ошибка создания QR кода'];
        }
    }

    public function actionRedirect($code)
    {
        $model = ShortUrl::findOne(['short_code' => $code]);
        if (!$model) {
            throw new NotFoundHttpException("Ссылка не найдена");
        }

        $model->updateCounters(['clicks' => 1]);

        $log = new UrlClickLog([
            'short_url_id' => $model->id,
            'ip_address' => Yii::$app->request->userIP
        ]);
        $log->save(false);

        return $this->redirect($model->original_url);
    }

    private function checkUrlAvailable($url)
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }

}
