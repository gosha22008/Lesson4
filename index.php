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
$key = b57497d52bec4a649c3c44fb650ade5f;
$content = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=$key");
file_put_contents('text.txt', $content);
$content1 = [];
$content1 = json_decode($content, true);

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
    if ($deg == 0 or $deg == 360) {
        $wind_deg = 'северный';
    } else if ($deg > 0 and $deg < 90) {
        $wind_deg = 'северо-восточный';
    } else if ($deg == 90) {
        $wind_deg = 'восточный';
    } else if ($deg > 90 and $deg < 180) {
        $wind_deg = 'юго-восточный';
    } else if ($deg == 180) {
        $wind_deg = 'южный';
    } else if ($deg > 180 and $deg < 270) {
        $wind_deg = 'юго-западный';
    } else if ($deg == 270) {
        $wind_deg = 'западный';
    } else if ($deg > 270 and $deg < 360) {
        $wind_deg = 'северо-западный';
    }
    return $wind_deg;
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
    <dd><?=$temp_grad?>&#176</dd>
</dl><dl>
    <dt>Минимальная температура</dt>
    <dd><?=$temp_min?>&#176</dd>
</dl>
<dl>
    <dt>Максимальная температура</dt>
    <dd><?=$temp_max?>&#176</dd>
</dl>
<dl>
    <dt>Давление</dt>
    <dd><?=$pressure?> мм.рт.ст.</dd>
</dl>
<dl>
    <dt>Влажность</dt>
    <dd><?=$humidity?>%</dd>
</dl>
<dl>
    <dt>Скорость ветра</dt>
    <dd><?=$wind_speed?> м/с</dd>
</dl>
<dl>
    <dt>Направление ветра</dt>
    <dd><?=$wind_deg?></dd>
</dl>
</body>