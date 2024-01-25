<?php

namespace App\Console\Commands\Builder;

use App\Services\Builder\MakeCrudService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'builder:make-crud {crud} {--package=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new CRUD';


    public function __construct(private readonly MakeCrudService $crudService)
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Log::info('start builder:make-crud at '.now());

            $this->crudService->make($this->option('package'), $this->argument('crud'));

            Log::info('finished builder:make-crud at '.now());
        } catch(\Throwable $th) {
            Log::error('error in builder:make-crud at '.now());
            Log::error($th);
        }
    }
}
