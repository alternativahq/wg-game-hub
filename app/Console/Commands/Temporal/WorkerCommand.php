<?php

namespace App\Console\Commands\Temporal;

use Illuminate\Console\Command;
use Temporal\WorkerFactory;

class WorkerCommand extends Command
{
    protected $signature = 'temporal:worker';

    protected $description = 'Command description';

    public function handle()
    {
        $factory = WorkerFactory::create();
        $worker = $factory->newWorker();

        $worker->registerWorkflowTypes(\App\Services\Temporal\Workflows\GameLobbyPrizeTransactionWorkflow::class);
        $worker->registerActivity(\App\Services\Temporal\Activities\GameLobbyPrizeTransactionActivity::class);

        $factory->run();
    }
}
