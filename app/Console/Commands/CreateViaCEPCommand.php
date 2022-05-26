<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Traits\CepTrait;

class CreateViaCEPCommand extends Command
{
    use CepTrait;

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
        $responseCollection = $this->fetchData($this->argument('ceps'));
    
        $this->info($responseCollection);
    }
}
