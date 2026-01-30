<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Log\Handlers\FileHandler;

class Logger extends BaseConfig
{
    /**
     * Logging threshold (9 = all messages)
     */
    public int $threshold = 9;

    /**
     * Date format for log entries
     */
    public string $dateFormat = 'Y-m-d H:i:s';

    /**
     * Log Handlers
     */
    public array $handlers = [
        'CodeIgniter\Log\Handlers\FileHandler' => [
            'handles' => [
                'critical',
                'alert',
                'emergency',
                'debug',
                'error',
                'info',
                'notice',
                'warning',
            ],
            'config' => [
                'path' => WRITEPATH . 'logs/',
            ],
        ],
    ];
}
