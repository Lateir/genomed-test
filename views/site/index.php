<?php

use yii\web\JqueryAsset;

$this->registerJsFile('@web/js/main.js', ['depends' => JqueryAsset::class]);

$this->title = 'Genomed QR';
?>

<div class="container mt-5">
    <div class="form-inline">
        <label for="url"></label><input type="text" class="form-control mr-2" id="url" placeholder="Введите ссылку">
        <button class="btn btn-primary" id="submit">ОК</button>
    </div>
    <div id="result" class="mt-4"></div>
</div>