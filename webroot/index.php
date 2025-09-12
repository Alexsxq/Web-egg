<?php
// Получаем информацию о PHP и сервере
$phpVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Неизвестно';
$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'Неизвестно';
$requestTime = date('Y-m-d H:i:s');
$phpExtensions = get_loaded_extensions();
$memoryUsage = memory_get_usage(true);
$maxMemory = memory_get_peak_usage(true);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о сервере</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --success-color: #16a34a;
            --warning-color: #ea580c;
            --info-color: #0891b2;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--dark-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 90%;
            max-width: 800px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .subtitle {
            font-size: 1.2em;
            color: var(--dark-color);
            opacity: 0.8;
        }

        .status-badge {
            display: inline-block;
            background: var(--success-color);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            margin-top: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: var(--light-color);
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .info-card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .info-card p {
            font-size: 1.1em;
            font-weight: 600;
            color: var(--dark-color);
        }

        .php-version {
            background: var(--primary-color);
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
            font-size: 1.3em;
            font-weight: 700;
        }

        .extensions {
            background: var(--light-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .extensions h3 {
            color: var(--info-color);
            margin-bottom: 15px;
        }

        .extensions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .extension-tag {
            background: var(--info-color);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .instructions {
            background: var(--warning-color);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .instructions h3 {
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            margin-top: 8px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-color);
            border-radius: 4px;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🚀 Сервер успешно настроен</h1>
        <p class="subtitle">Ваш веб-сервер готов к работе!</p>
        <div class="status-badge">✅ Активен</div>
    </div>

    <div class="php-version">
        Текущая версия PHP: <?php echo $phpVersion; ?>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3>🌐 Сервер</h3>
            <p><?php echo $serverSoftware; ?></p>
        </div>
        
        <div class="info-card">
            <h3>📁 Домен</h3>
            <p><?php echo $serverName; ?></p>
        </div>
        
        <div class="info-card">
            <h3>📊 Память</h3>
            <p><?php echo round($memoryUsage / 1024 / 1024, 2); ?> MB / <?php echo round($maxMemory / 1024 / 1024, 2); ?> MB</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo min(($memoryUsage / $maxMemory) * 100, 100); ?>%"></div>
            </div>
        </div>
        
        <div class="info-card">
            <h3>🕐 Время запроса</h3>
            <p><?php echo $requestTime; ?></p>
        </div>
    </div>

    <div class="extensions">
        <h3>📦 Активные расширения PHP</h3>
        <div class="extensions-list">
            <?php 
            $displayExtensions = array_slice($phpExtensions, 0, 15);
            foreach ($displayExtensions as $ext) {
                echo '<span class="extension-tag">' . $ext . '</span>';
            }
            if (count($phpExtensions) > 15) {
                echo '<span class="extension-tag">+' . (count($phpExtensions) - 15) . ' ещё...</span>';
            }
            ?>
        </div>
    </div>

    <div class="instructions">
        <h3>📝 Следующие шаги</h3>
        <p>1. Разместите файлы вашего сайта в папке "webroot"</p>
        <p>2. Настройте базу данных если необходимо</p>
        <p>3. Проверьте настройки безопасности</p>
        <p>4. Наслаждайтесь работой вашего сайта!</p>
    </div>

    <div class="footer">
        <p>Создано с ❤️ | Работает на <a href="https://zertix.pw/" target="_blank">zertix.pw</a></p>
        <p>Ваш IP: <?php echo $clientIP; ?></p>
    </div>
</div>

</body>
