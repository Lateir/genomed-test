<?php

use yii\web\JqueryAsset;

$this->registerJsFile('@web/js/main.js', ['depends' => JqueryAsset::class]);

$this->title = 'QR Генератор';
?>

<div class="container mt-5">
    <div class="form-group">
        <label for="url" class="form-label">Введите ссылку для создания QR-кода:</label>
        <div class="form-inline">
            <input type="text" class="form-control mr-2" id="url" placeholder="https://example.com">
            <button class="btn btn-primary mt-4" id="submit">
                <span id="button-text">ОК</span>
                <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    <div id="result" class="mt-4"></div>
</div>
