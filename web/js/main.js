$('#submit').on('click', function () {
    const url = $('#url').val();
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
    });
});
