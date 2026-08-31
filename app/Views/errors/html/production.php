<!doctype html>
<html lang="id" class="layout-compact">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex">
    <title>Terjadi Kesalahan - KBRA</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>/assets/css/demo.css" />

    <style>
        body {
            background-color: #f5f5f9;
            font-family: 'Public Sans', sans-serif;
        }

        .misc-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 2rem;
        }

        .error-icon-box {
            width: 100px;
            height: 100px;
            background: #ffe5e5;
            color: #ff3e1d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <div class="error-icon-box">
                <i class="ri-error-warning-line"></i>
            </div>
            <h3 class="mb-2 fw-bold">Terjadi Kesalahan Sistem</h3>
            <p class="mb-4 text-muted" style="max-width: 450px;">
                Maaf, sistem mengalami kendala teknis saat memproses permintaan Anda. Silakan coba beberapa saat lagi.
            </p>
            <div class="d-flex gap-2">
                <a href="javascript:history.back()" class="btn btn-outline-secondary">
                    <i class="ri-arrow-left-line me-1"></i> Kembali
                </a>
                <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">
                    <i class="ri-home-smile-line me-1"></i> Beranda
                </a>
            </div>
        </div>
    </div>
</body>

</html>