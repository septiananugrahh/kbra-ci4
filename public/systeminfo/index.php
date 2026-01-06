<?php
// Fungsi untuk mendapatkan informasi CPU
function get_cpu_info()
{
  $cpuinfo = @file_get_contents("/proc/cpuinfo");
  if (!$cpuinfo) return ['model' => 'Tidak tersedia', 'cores' => 0];

  preg_match("/model name\s+:\s+(.+)/", $cpuinfo, $model);
  preg_match_all("/^processor/m", $cpuinfo, $cores);

  return [
    'model' => $model[1] ?? 'Unknown',
    'cores' => count($cores[0])
  ];
}

// Fungsi untuk mendapatkan informasi Memori
function get_memory_info()
{
  $meminfo = @file_get_contents("/proc/meminfo");
  if (!$meminfo) return ['total' => 0, 'available' => 0, 'used' => 0];

  preg_match("/MemTotal:\s+(\d+)/", $meminfo, $total);
  preg_match("/MemAvailable:\s+(\d+)/", $meminfo, $available);

  $totalMB = round($total[1] / 1024, 2);
  $availableMB = round($available[1] / 1024, 2);
  $usedMB = round($totalMB - $availableMB, 2);

  return [
    'total' => $totalMB,
    'available' => $availableMB,
    'used' => $usedMB
  ];
}

// Fungsi untuk mendapatkan uptime
function get_uptime()
{
  $uptime = @file_get_contents("/proc/uptime");
  if (!$uptime) return 'Tidak tersedia';

  $seconds = (int) explode(' ', $uptime)[0];
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds % 3600) / 60);
  return "{$hours} jam {$minutes} menit";
}

// Fungsi untuk mengecek server web (Apache/Nginx/dll)
function get_web_server()
{
  if (!empty($_SERVER['SERVER_SOFTWARE'])) {
    return $_SERVER['SERVER_SOFTWARE'];
  } elseif (function_exists('apache_get_version')) {
    return apache_get_version();
  } else {
    return php_sapi_name();
  }
}

// Panggil fungsi
$cpu = get_cpu_info();
$mem = get_memory_info();
$uptime = get_uptime();
$webserver = get_web_server();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Informasi Sistem Server</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: #f7f9fc;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      background: white;
      border-radius: 12px;
      padding: 30px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      margin-top: 0;
      color: #2c3e50;
      text-align: center;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      padding: 12px 0;
      border-bottom: 1px solid #eee;
      font-size: 16px;
    }

    li:last-child {
      border-bottom: none;
    }

    strong {
      color: #34495e;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      color: #999;
      font-size: 13px;
    }

    @media (max-width: 600px) {
      .container {
        padding: 20px;
      }

      li {
        font-size: 15px;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <h2>Informasi Sistem Server</h2>
    <ul>
      <li><strong>Web Server:</strong> <?= htmlspecialchars($webserver) ?></li>
      <li><strong>CPU:</strong> <?= htmlspecialchars($cpu['model']) ?> (<?= $cpu['cores'] ?> core)</li>
      <li><strong>Total RAM:</strong> <?= $mem['total'] ?> MB</li>
      <li><strong>RAM Digunakan:</strong> <?= $mem['used'] ?> MB</li>
      <li><strong>RAM Tersedia:</strong> <?= $mem['available'] ?> MB</li>
      <li><strong>Uptime:</strong> <?= $uptime ?></li>
    </ul>
    <div class="footer">Dibuat dengan ❤️ menggunakan PHP Native</div>
  </div>

</body>

</html>