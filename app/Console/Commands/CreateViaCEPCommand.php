<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ViacepService;

class CreateViaCEPCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viacep:search {ceps}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for a list of ceps';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cepService = new ViacepService();

        $this->info(json_encode($cepService->getLocation($this->argument('ceps'))));
    }
}
