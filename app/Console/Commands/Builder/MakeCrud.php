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
    protected $signature = '
    builder:make-crud {crud} {--package=} {--string-field=*} {--int-field=*} {--float-field=*} {--uuid-field=*} {--date-field=*} {--datetime-field=*} {--text-field=*} {--bool-field=*} {--belongs-to=*} {--has-many=*}
    ';

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

            $allOptions = $this->options();
            $LaravelDefaultOptions = $this->getApplication()->getDefinition()->getOptions();
            $options = array_diff_key($allOptions, $LaravelDefaultOptions);

            $this->crudService->make($this->argument('crud'), $options);

            Log::info('finished builder:make-crud at '.now());
        } catch(\Throwable $th) {
            Log::error('error in builder:make-crud at '.now());
            Log::error($th);
        }
    }
}
