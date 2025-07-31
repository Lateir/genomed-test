<?php

namespace app\controllers;

use app\models\services\UrlShortenerService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    private $urlShortenerService;

    public function init()
    {
        parent::init();
        $this->urlShortenerService = new UrlShortenerService();
    }

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
     * Отображает главную страницу
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Создает короткую ссылку
     */
    public function actionShorten()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $url = Yii::$app->request->post('url');
        return $this->urlShortenerService->shortenUrl($url);
    }

    /**
     * Перенаправляет по короткой ссылке
     */
    public function actionRedirect($code)
    {
        $shortUrl = $this->urlShortenerService->processRedirect($code);

        if ($shortUrl === null) {
            throw new NotFoundHttpException("Ссылка не найдена");
        }

        return $this->redirect($shortUrl->original_url);
    }
}