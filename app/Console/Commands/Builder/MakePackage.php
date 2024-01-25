<?php

namespace App\Console\Commands\Builder;

use App\Services\Builder\MakePackageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MakePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'builder:make-package {package}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new CRUD';


    public function __construct(private readonly MakePackageService $packageService)
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Log::info('start builder:make-package at '.now());

            $this->packageService->make($this->argument('package'));

            Log::info('finished builder:make-package at '.now());
        } catch(\Throwable $th) {
            Log::error('error in builder:make-package at '.now());
            Log::error($th);
        }
    }
}
