<?php

namespace App\Libraries;

use CodeIgniter\Log\Handlers\FileHandler;
use CodeIgniter\Log\Logger;

class SlowQueryLogger
{
    protected $logger;
    protected $threshold;

    public function __construct()
    {
        try {
            $this->threshold = (float) (env('database.slowQueryThreshold') ?? 1.0);

            $handler = new FileHandler([
                'path' => WRITEPATH . 'logs/slow_queries/',
                'fileExtension' => 'log',
                'filePermissions' => 0644,
            ]);

            $this->logger = new Logger([
                'handlers' => [$handler],
                'threshold' => 9, // Log semua level
            ]);
        } catch (\Exception $e) {
            // Fallback ke system log jika error
            log_message('error', 'Failed to initialize SlowQueryLogger: ' . $e->getMessage());
            $this->logger = service('logger');
            $this->threshold = 1.0;
        }
    }

    public function logQuery(float $duration, string $query, array $bindings = [])
    {
        try {
            if ($duration > $this->threshold) {
                $message = sprintf(
                    "[%s] Slow Query (%.3fs): %s",
                    date('Y-m-d H:i:s'),
                    $duration,
                    $this->formatQuery($query, $bindings)
                );

                $this->logger->log('warning', $message);
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to log slow query: ' . $e->getMessage());
        }
    }


    protected function formatQuery(string $query, array $bindings): string
    {
        if (empty($bindings)) {
            return $query;
        }

        $indexed = array_values($bindings) === $bindings;
        foreach ($bindings as $key => $value) {
            $value = is_string($value) ? "'{$value}'" : $value;
            if ($indexed) {
                $query = preg_replace('/\?/', $value, $query, 1);
            } else {
                $query = str_replace(':' . $key, $value, $query);
            }
        }

        return $query;
    }
}
