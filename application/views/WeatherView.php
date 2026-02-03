<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eceff1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-width: 300px;
        }

        .temp {
            font-size: 4rem;
            font-weight: bold;
            color: #1a237e;
            margin: 10px 0;
        }

        .location {
            color: #546e7a;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .error {
            color: #d32f2f;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card">
        <?php if ($data->hasData()): ?>
            <div class="location">Weather in <?= $data->cityName ?></div>
            <div class="temp"><?= $data->temperature ?>°C</div>
            <p>Conditions: <?= ucfirst($data->description) ?></p>
            <p>Humidity: <?= $data->humidity ?>%</p>
        <?php elseif ($data->errorMessage): ?>
            <p class="error">API Error: <?= $data->errorMessage ?></p>
        <?php else: ?>
            <p>Data unavailable. Please check your connection or API key.</p>
        <?php endif; ?>
    </div>
</body>

</html>