<?php
$phpVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Неизвестно';
$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
$serverPort = $_SERVER['SERVER_PORT'] ?? '80';
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'Неизвестно';
$requestTime = date('Y-m-d H:i:s');
$phpExtensions = get_loaded_extensions();
$memoryUsage = memory_get_usage(true);
$maxMemory = memory_get_peak_usage(true);

$cpuCount = shell_exec('nproc') ? (int)shell_exec('nproc') : 1;
$load = sys_getloadavg();
$loadPercent = $load[0] / $cpuCount * 100;

function calculatePercentage($used, $total) {
    if ($total <= 0) return 0;
    return min(($used / $total) * 100, 100);
}

$phpMemoryPercent = calculatePercentage($memoryUsage, $maxMemory);

// Получаем реальный IP сервера
$serverIP = $_SERVER['SERVER_ADDR'] ?? '0.0.0.0';
$domainWithPort = $serverIP . ':' . $serverPort;
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Zertix • Информация о сервере</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --bg: #0b0b12;
      --panel: rgba(255, 255, 255, 0.06);
      --border: rgba(255, 255, 255, 0.12);
      --text: #fff;
      --muted: #a3a3b2;
      --accent: #ffffff;
      --radius-xl: 24px;
      --radius-md: 14px;
      --shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
    body {
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: 
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 40px 40px;
      z-index: -1;
    }
    header {
      position: sticky;
      top: 0;
      background: var(--panel);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border);
      padding: 16px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .brand {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--accent);
      cursor: pointer;
    }
    .panel-link {
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1em;
    }
    .panel-link:hover {
      text-decoration: underline;
    }
    .main-content {
      flex: 1;
      display: flex;
      justify-content: center;
      padding: 40px 20px;
    }
    .container {
      width: 100%;
      max-width: 900px;
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 32px;
      box-shadow: var(--shadow);
      animation: fadeIn 0.6s ease-out;
    }
    h1 {
      font-size: 2rem;
      font-weight: 700;
      text-align: center;
      margin-bottom: 20px;
      color: var(--accent);
    }
    .status-badge {
      text-align: center;
      background: rgba(16,185,129,0.15);
      border: 1px solid rgba(16,185,129,0.3);
      color: #10b981;
      padding: 8px 16px;
      border-radius: 12px;
      font-weight: 600;
      margin: 10px auto 30px;
      width: fit-content;
    }
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    .info-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 20px;
    }
    .info-card h3 {
      font-size: 1.1em;
      margin-bottom: 8px;
      color: var(--muted);
    }
    .info-card p {
      font-size: 1.1em;
      font-weight: 600;
      color: var(--text);
      word-break: break-all;
    }
    .php-version {
      text-align: center;
      background: rgba(99,102,241,0.15);
      border: 1px solid rgba(99,102,241,0.3);
      color: #818cf8;
      padding: 15px;
      border-radius: var(--radius-md);
      margin-bottom: 30px;
      font-weight: 700;
    }
    .extensions {
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 20px;
      margin-bottom: 30px;
    }
    .extensions h3 { margin-bottom: 12px; color: var(--muted); }
    .extensions-list {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }
    .extension-tag {
      background: rgba(129,140,248,0.15);
      border: 1px solid rgba(129,140,248,0.3);
      color: #818cf8;
      padding: 4px 10px;
      border-radius: 10px;
      font-size: 0.85em;
    }
    .instructions {
      background: rgba(251,191,36,0.1);
      border: 1px solid rgba(251,191,36,0.3);
      color: #facc15;
      border-radius: var(--radius-md);
      padding: 20px;
      margin-bottom: 30px;
    }
    .progress-bar {
      width: 100%;
      height: 6px;
      background: rgba(255,255,255,0.1);
      border-radius: 3px;
      margin-top: 8px;
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: #818cf8;
      border-radius: 3px;
      transition: width 0.3s ease;
    }
    .resource-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 20px;
      margin-bottom: 20px;
    }
    .resource-card h3 {
      font-size: 1.1em;
      margin-bottom: 12px;
      color: var(--muted);
    }
    .resource-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      font-size: 0.95em;
    }
    .resource-percent {
      text-align: right;
      font-weight: 600;
      color: #818cf8;
    }
    .refresh-btn {
      background: rgba(99,102,241,0.15);
      border: 1px solid rgba(99,102,241,0.3);
      color: #818cf8;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      display: block;
      margin: 20px auto;
      transition: all 0.3s ease;
    }
    .refresh-btn:hover {
      background: rgba(99,102,241,0.25);
    }
    footer {
      text-align: center;
      padding: 20px;
      color: var(--muted);
      font-size: 0.9rem;
      border-top: 1px solid var(--border);
    }
    footer a { color: var(--accent); text-decoration: none; }
    footer a:hover { text-decoration: underline; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <header>
    <div class="brand">Zertix</div>
    <a href="https://panel.zertix.pw" class="panel-link" target="_blank">Панель</a>
  </header>

  <div class="main-content">
    <div class="container">
      <h1>Информация о сервере</h1>
      <div class="status-badge"> Активен</div>

      <div class="resource-card">
        <h3><i class="fas fa-microchip"></i> Процессор</h3>
        <div class="resource-info">
          <span>Ядра: <?= $cpuCount ?></span>
          <span class="resource-percent">Нагрузка: <?= round($load[0], 2) ?></span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width: <?= min($loadPercent, 100) ?>%"></div>
        </div>
      </div>

      <button class="refresh-btn" onclick="window.location.reload()">
        <i class="fas fa-sync-alt"></i> Обновить данные
      </button>

      <div class="info-grid">
        <div class="info-card">
          <h3><i class="fas fa-server"></i> Сервер</h3>
          <p><?= $serverSoftware ?></p>
        </div>
		<div class="info-card">
            <h3><i class="fas fa-globe"></i> Домен</h3>
    	 	<p>h1.zertix.pw:<?= $serverPort ?></p>
		</div>
        <div class="info-card">
          <h3><i class="fas fa-clock"></i> Время запроса</h3>
          <p><?= $requestTime ?></p>
        </div>
      </div>

      <div class="extensions">
        <h3><i class="fas fa-puzzle-piece"></i> Активные расширения PHP</h3>
        <div class="extensions-list">
          <?php 
          $displayExtensions = array_slice($phpExtensions, 0, 12);
          foreach ($displayExtensions as $ext) {
            echo '<span class="extension-tag">' . $ext . '</span>';
          }
          if (count($phpExtensions) > 12) {
            echo '<span class="extension-tag">+' . (count($phpExtensions) - 12) . ' ещё...</span>';
          }
          ?>
        </div>
      </div>

      <div class="instructions">
        <h3><i class="fas fa-list"></i> Следующие шаги</h3>
        <p>1. Разместите файлы вашего сайта в папке "webroot"</p>
        <p>2. Настройте базу данных если необходимо</p>
        <p>3. Проверьте настройки безопасности</p>
        <p>4. Наслаждайтесь работой вашего сайта!</p>
      </div>
    </div>
  </div>

  <footer>
    © <?= date('Y') ?> Zertix • <a href="https://zertix.pw/" target="_blank">zertix.pw</a> | IP: <?= $clientIP ?>
  </footer>
</body>
</html>
