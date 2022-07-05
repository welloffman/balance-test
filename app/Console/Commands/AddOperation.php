<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessOperation;

class AddOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:operation {email} {type} {amount} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проведение операции';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            'email' => $this->argument('email'),
            'type' => $this->argument('type'),
            'amount' => (float)$this->argument('amount'),
            'description' => $this->argument('description'),
        ];

        ProcessOperation::dispatch($data);

        $this->info("Операция добавлена в очередь");
    }
}
