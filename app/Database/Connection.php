<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;

class Connection extends BaseConnection
{
    protected $slowQueryThreshold = 1;

    protected function logSlowQuery($sql, $startTime, $bindings)
    {
        $duration = microtime(true) - $startTime;

        if ($duration > $this->slowQueryThreshold) {
            $message = "Slow Query Detected ({$duration} sec): {$sql}";

            if (!empty($bindings)) {
                $message .= " [Bindings: " . implode(', ', $bindings) . "]";
            }

            log_message('warning', $message);
        }
    }

    public function query($sql, $binds = null, $setEscapeFlags = true, $queryClass = 'CodeIgniter\\Database\\Query')
    {
        $startTime = microtime(true);
        $result = parent::query($sql, $binds, $setEscapeFlags, $queryClass);
        $this->logSlowQuery($sql, $startTime, $binds);

        return $result;
    }
}
