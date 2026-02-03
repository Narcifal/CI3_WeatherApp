<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
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
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
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
        .history-wrapper {
            display: flex;
            gap: 15px;
            width: 350px;
        }
        .history-box {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            flex: 1;
            text-align: center;
            font-size: 0.9rem;
            border-top: 4px solid #90a4ae;
        }
        .history-box.empty {
            opacity: 0.6;
            border-top: 4px solid #cfd8dc;
        }
        .history-box h4 {
            margin: 0 0 8px 0;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #90a4ae;
            letter-spacing: 1px;
        }
        .history-temp {
            font-size: 1.4rem;
            font-weight: bold;
            color: #283593;
        }
        .error {
            color: #d32f2f;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($data->isValid()): ?>
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

    <div class="history-wrapper">
        <?php if (count($history) === 2): $row = $history[1]; ?>
            <div class="history-box">
                <h4>Previous Saved</h4>
                <div class="history-temp"><?= $row['temperature'] ?>°C</div>
                <div style="color: #546e7a;"><?= ucfirst($row['description']) ?></div>
                <div style="font-size: 0.7rem; color: #b0bec5; margin-top: 5px;">
                    <?= date('d.m.Y H:i:s', strtotime($row['created_at'])) ?>
                </div>
            </div>
        <?php else: ?>
            <div class="history-box empty">
                <h4>Previous Saved</h4>
                <div class="history-temp">--°C</div>
                <div style="color: #b0bec5;">
                    <?= count($history) === 1 ? 'Waiting for data...' : 'No records yet' ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($history)): $row = $history[0]; ?>
            <div class="history-box">
                <h4>Latest Saved</h4>
                <div class="history-temp"><?= $row['temperature'] ?>°C</div>
                <div style="color: #546e7a;"><?= ucfirst($row['description']) ?></div>
                <div style="font-size: 0.7rem; color: #b0bec5; margin-top: 5px;">
                    <?= date('d.m.Y H:i:s', strtotime($row['created_at'])) ?>
                </div>
            </div>
        <?php else: ?>
            <div class="history-box empty">
                <h4>Latest Saved</h4>
                <div class="history-temp">--°C</div>
                <div style="color: #b0bec5;">No records yet</div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>