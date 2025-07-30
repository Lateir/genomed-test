// Изначально отключаем кнопку
$('#submit').prop('disabled', true);

// Регулярное выражение для проверки URL вида https://*.*
const urlPattern = /^https:\/\/.+\..+/;

// Отслеживаем изменения в поле ввода URL
$('#url').on('input', function() {
    const url = $(this).val().trim();

    // Проверка URL с помощью регулярного выражения
    const isValidUrl = urlPattern.test(url);

    // Включаем/отключаем кнопку в зависимости от валидности URL
    $('#submit').prop('disabled', !isValidUrl);

    // Визуальная обратная связь для пользователя
    if (url.length > 0) {
        if (isValidUrl) {
            $('#url').removeClass('is-invalid').addClass('is-valid');
        } else {
            $('#url').removeClass('is-valid').addClass('is-invalid');
        }
    } else {
        $('#url').removeClass('is-valid is-invalid');
    }
});

// Функция для показа лоадера
function showLoader() {
    $('#button-text').addClass('d-none');
    $('#loader').removeClass('d-none');
    $('#submit').prop('disabled', true);
}

// Функция для скрытия лоадера
function hideLoader() {
    $('#button-text').removeClass('d-none');
    $('#loader').addClass('d-none');

    // Проверяем валидность URL для правильного состояния кнопки
    const url = $('#url').val().trim();
    const isValidUrl = urlPattern.test(url);
    $('#submit').prop('disabled', !isValidUrl);
}

$('#submit').on('click', function () {
    const url = $('#url').val();

    // Показываем лоадер
    showLoader();

    $.post('/site/shorten', { url }, function (res) {
        if (res.error) {
            $('#result').html(`<div class="alert alert-danger">${res.error}</div>`);
        } else {
            $('#result').html(`
                <div class="alert alert-success">
                    <img src="${res.qr}" width="200"><br>
                    Короткая ссылка: <a href="${res.shortUrl}" target="_blank">${res.shortUrl}</a>
                </div>
            `);
        }
    }).fail(function() {
        $('#result').html(`<div class="alert alert-danger">Произошла ошибка при отправке запроса</div>`);
    }).always(function() {
        hideLoader();
    });
});