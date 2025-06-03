<?php

namespace App\Listeners;

use CodeIgniter\Database\Events\QueryEvent;
use CodeIgniter\Database\Query;

class DatabaseListener
{
    protected $slowQueryThreshold;

    public function __construct()
    {
        // Set threshold dari .env atau default 1 detik
        $this->slowQueryThreshold = (float) env('database.slowQueryThreshold', 0);
    }

    public function handleQueryEvent($event)
    {
        if ($event instanceof QueryEvent) {
            $this->logSlowQuery($event);
        }
        // Abaikan jika bukan QueryEvent
    }

    protected function logSlowQuery(QueryEvent $event)
    {
        $duration = $event->duration / 1000; // Convert ms to seconds

        if ($duration > $this->slowQueryThreshold) {
            $query = $event->query;
            $bindings = $event->bindings ?? [];

            $message = sprintf(
                "SLOW QUERY (%.3f sec): %s",
                $duration,
                $query
            );

            if (!empty($bindings)) {
                $message .= " [Bindings: " . implode(', ', $bindings) . "]";
            }

            log_message('warning', $message);
        }
    }
}
