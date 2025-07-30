
<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

// Регистрируем дополнительные стили
$this->registerCss('
    :root {
        --primary-color: #6366f1;
        --primary-hover: #4f46e5;
        --secondary-color: #f8fafc;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    body {
        font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
        color: var(--text-primary);
    }

    .main-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .app-card {
        background: white;
        border-radius: 24px;
        box-shadow: var(--shadow-lg);
        max-width: 500px;
        width: 100%;
        padding: 3rem 2rem;
        text-align: center;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .app-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .app-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 2.5rem;
        font-weight: 400;
    }

    .form-group {
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--secondary-color);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        background: white;
    }

    .btn-primary {
        background: var(--primary-color);
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 0.5rem;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .result-container {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--secondary-color);
        border-radius: 16px;
        border: 1px solid var(--border-color);
    }

    .qr-code-container {
        display: flex;
        justify-content: center;
        margin: 1.5rem 0;
    }

    .short-url {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        font-family: "JetBrains Mono", monospace;
        word-break: break-all;
        color: var(--primary-color);
        font-weight: 500;
    }

    .footer {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 1000;
        max-width: 220px;
    }
    
    .footer .footer-link {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }
    
    .footer a {
        color: #495057;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .footer a:hover {
        color: var(--primary-color, #0d6efd); /* fallback если переменная не определена */
    }
    
    @media (max-width: 576px) {
        .footer {
            position: static;
            margin: 3rem auto 1rem;
            text-align: center;
        }
    }

    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        color: #15803d;
        border-left: 4px solid #22c55e;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border-left: 4px solid #ef4444;
    }

    @media (max-width: 576px) {
        .app-card {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .app-title {
            font-size: 2rem;
        }
        
        .footer {
            position: relative;
            text-align: center;
            margin-top: 2rem;
        }
    }

    /* Анимация появления */
    .app-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
');

// Подключаем Google Fonts
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => '']);
$this->registerLinkTag(['rel' => 'stylesheet', 'href' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap']);
$this->registerLinkTag(['rel' => 'stylesheet', 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="main-container">
    <div class="app-card">
        <h1 class="app-title">QR Generator</h1>
        <p class="app-subtitle">Тестовое задание Геномед</p>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<div class="footer">
    <div class="card border-0 bg-transparent shadow-sm">
        <div class="card-body text-center p-3">
            <div class="footer-link d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-person-circle text-primary fs-5"></i>
                <a href="https://lateir.ru" target="_blank" rel="noopener noreferrer">
                    Даниил Поветкин
                </a>
            </div>
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>