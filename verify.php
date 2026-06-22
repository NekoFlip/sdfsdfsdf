<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем секретный ключ и токен капчи от формы
    $secretKey = "6LfxTy0tAAAAAGNrYznGuDGBVEhDVOrlst-0kh_W";
    $captchaResponse = $_POST['g-recaptcha-response'];

    // Проверяем, заполнена ли капча
    if (empty($captchaResponse)) {
        die("Пожалуйста, подтвердите, что вы не робот.");
    }

    // Отправляем запрос на сервера Google для проверки
    $url = 'https://google.com';
    $data = [
        'secret' => $secretKey,
        'response' => $captchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $responseKeys = json_decode($response, true);

    // Обрабатываем ответ Google
    if ($responseKeys["success"]) {
        echo "Капча успешно пройдена! Данные формы обработаны.";
        // Здесь пишите код отправки письма или сохранения в базу данных
    } else {
        echo "Проверка не пройдена. Попробуйте еще раз.";
    }
}
?>
