<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Defaults;

class DefaultsLoadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'defaults:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load default system paramenters to be used by the system ....';

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
        app(Defaults::class)->load();

        $this->info('## Defualts loaded successfully ....');
    }
}
