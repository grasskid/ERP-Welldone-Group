<?php

namespace App\Listeners;

use CodeIgniter\Database\Events\QueryEvent;
use CodeIgniter\Database\Query;
use App\Libraries\SlowQueryLogger;

class SlowQueryListener
{
    protected $logger;

    public function __construct()
    {
        $this->logger = new SlowQueryLogger();
    }

    public function handle($event)
    {
        // Handle QueryEvent (post-execution with duration)
        if ($event instanceof QueryEvent) {
            $this->handleQueryEvent($event);
        }
        // Handle Query (pre-execution) - skip if you only want timing
        // elseif ($event instanceof Query) {
        //     $this->handlePreQuery($event);
        // }
    }

    protected function handleQueryEvent(QueryEvent $event)
    {
        try {
            $duration = $event->duration / 1000; // Convert ms to seconds
            $this->logger->logQuery(
                $duration,
                $event->query,
                $event->bindings ?? []
            );
        } catch (\Exception $e) {
            log_message('error', 'Failed to log query: ' . $e->getMessage());
        }
    }

    // Optional: For pre-execution logging
    // protected function handlePreQuery(Query $query)
    // {
    //     // Log query before execution if needed
    // }
}
