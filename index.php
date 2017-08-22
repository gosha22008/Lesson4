<!DOCTYPE>
<html lang="ru">
<head>
    <title>Задание</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
        }

        dl {
            display: table-row;
        }

        dt, dd {
            display: table-cell;
            padding: 5px 10px;
        }
    </style>
</head>
<?php
$key = 'b57497d52bec4a649c3c44fb650ade5f';
if (!file_exists('text.txt')) {
    $content = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=$key");
    file_put_contents('text.txt', $content);
    $content1 = [];
    $content1 = json_decode($content, true);
} else if (file_exists('text.txt')) {
    $time1 = time();
    $a = $time1 - filemtime('text.txt');
    if ($a > 3600) {
        $content = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=$key");
        file_put_contents('text.txt', $content);
        $content1 = json_decode($content, true);
    }
    else {
        $con = file_get_contents('text.txt');
        $content1 = json_decode($con, true);
    }
}
function convert_temp($temp_kelvin)
{
    $temp_grad = $temp_kelvin - 273.15;
    return $temp_grad;
}

function convert_pressure($hpa)
{
    $mm_rt = $hpa * 0.75;
    return $mm_rt;
}

function convert_deg($deg)
{
    switch ($deg) {
        case 0  :
            $wind_deg = 'северный';
            return $wind_deg;
            break;
        case 360 :
            $wind_deg = 'северный';
            return $wind_deg;
            break;
        case $deg > 0 and $deg < 90 :
            $wind_deg = 'северо-восточный';
            return $wind_deg;
            break;
        case $deg == 90 :
            $wind_deg = 'восточный';
            return $wind_deg;
            break;
        case $deg > 90 and $deg < 180 :
            $wind_deg = 'юго-восточный';
            return $wind_deg;
            break;
        case $deg == 180 :
            $wind_deg = 'южный';
            return $wind_deg;
            break;
        case $deg > 180 and $deg < 270 :
            $wind_deg = 'юго-западный';
            return $wind_deg;
            break;
        case $deg == 270 :
            $wind_deg = 'западный';
            return $wind_deg;
            break;
        case $deg > 270 and $deg < 360 :
            $wind_deg = 'северо-западный';
            return $wind_deg;
            break;
    }
}

$temp_grad = convert_temp($content1['main']['temp']);
$temp_min = convert_temp($content1['main']['temp_min']);
$temp_max = convert_temp($content1['main']['temp_max']);
$pressure = convert_pressure($content1['main']['pressure']);
$humidity = $content1['main']['humidity'];
$wind_speed = $content1['wind']['speed'];
$wind_deg = convert_deg($content1['wind']['deg']);
?>
<body>
<h2>Погода в Лондоне</h2>
<dl>
    <dt>Температура</dt>
    <dd><?= $temp_grad ?> &#176С</dd>
</dl>
<dl>
    <dt>Минимальная температура</dt>
    <dd><?= $temp_min ?> &#176С</dd>
</dl>
<dl>
    <dt>Максимальная температура</dt>
    <dd><?= $temp_max ?> &#176С</dd>
</dl>
<dl>
    <dt>Давление</dt>
    <dd><?= $pressure ?> мм.рт.ст.</dd>
</dl>
<dl>
    <dt>Влажность</dt>
    <dd><?= $humidity ?>%</dd>
</dl>
<dl>
    <dt>Скорость ветра</dt>
    <dd><?= $wind_speed ?> м/с</dd>
</dl>
<dl>
    <dt>Направление ветра</dt>
    <dd><?= $wind_deg ?></dd>
</dl>
</body>