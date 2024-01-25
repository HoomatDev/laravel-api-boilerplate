<?php

namespace App\Services\Builder;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakeCrudService
{
    private string $package_path;
    private string $package_name;
    private string $crud;
    private string $crud_item;
    private string $table;


    public function make(string $package, string $crud): void
    {
        $this->crud = Str::studly($crud);
        $this->crud_item = Str::camel($crud);
        $this->table = strtolower(Str::snake(Str::plural($crud)));

        $package_arr = explode('/', $package);
        $path = '';
        foreach ($package_arr as $name) {
            $path .= ucfirst($name) . '\\';
        }
        $this->package_path = substr($path, 0, -1);
        $this->package_name = ucfirst(Arr::last($package_arr));

        foreach ($this->getConfig() as $key => $value) {
            $folder = $key === 'migration' ? '/database/' : '/src/app/';
            Storage::disk('packages')->put(
                $package . $folder . $value,
                $this->parseClassText(config("builder.crud_texts.$key"))
            );
        }
    }


    private function parseClassText($text): array|string
    {
        $output = str_replace(
            array('{CLASS_NAME}', '{PACKAGE_NAME}', '{PACKAGE_PATH}', '{ITEM_NAME}', '{TABLE_NAME}'),
            array($this->crud, $this->package_name, $this->package_path, $this->crud_item, $this->table),
            $text
        );

        return "<?" . "php

" . $output;
    }


    private function getConfig(): array
    {
        $migrationName = Carbon::now()->format('Y_m_d_His') . '_create_' . $this->table . '_table.php';
        return [
            'migration' => "migrations/$migrationName",
            'model' => "Models/$this->crud.php",
            'dto' => "Models/DTOs/$this->crud" . 'DTO.php',
            'repository_interface' => "Repositories/Interfaces/$this->crud" . 'RepositoryInterface.php',
            'repository' => "Repositories/$this->crud" . 'Repository.php',
            'filter_scope' => "Scopes/$this->crud/$this->crud" . 'FilterScope.php',
            'sort_scope' => "Scopes/$this->crud/$this->crud" . 'SortScope.php',
            'load_scope' => "Scopes/$this->crud/$this->crud" . 'LoadScope.php',
            'search_scope' => "Scopes/$this->crud/$this->crud" . 'SearchScope.php',
            'service' => "Services/$this->crud" . 'Service.php',
            'resource' => "Http/Resources/$this->crud" . 'Resource.php',
            'request_index' => "Http/Requests/$this->crud/$this->crud" . 'IndexRequest.php',
            'request_store' => "Http/Requests/$this->crud/$this->crud" . 'StoreRequest.php',
            'request_update' => "Http/Requests/$this->crud/$this->crud" . 'UpdateRequest.php',
            'policy' => "Policies/$this->crud" . 'Policy.php',
            'controller' => "Http/Controllers/$this->crud" . 'Controller.php',
        ];
    }
}
