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
    private array $options;
    private array $fields = [
        'migration' => "",
        'model' => "",
        'dto' => "",
        'filter_scope' => "",
        'sort_scope' => "",
        'load_scope' => "",
        'resource' => "",
        'resource_imports' => "",
        'request_store' => "",
        'request_update' => "",
        'model_imports' => "",
        'model_relations' => ""
    ];


    public function make(string $crud, array $options): void
    {
        $package = $options['package'];
        $this->crud = Str::studly($crud);
        $this->crud_item = Str::camel($crud);
        $this->table = strtolower(Str::snake(Str::plural($crud)));
        unset($options['package']);
        $this->options = $options;

        $package_arr = explode('/', $package);
        $path = '';
        foreach ($package_arr as $name) {
            $path .= ucfirst($name) . '\\';
        }
        $this->package_path = substr($path, 0, -1);
        $this->package_name = ucfirst(Arr::last($package_arr));

        $this->parseOptions();

        foreach ($this->getConfig() as $key => $value) {
            $folder = $key === 'migration' ? '/database/' : '/src/app/';
            $text = config("builder.crud_texts.$key");

            $text = str_replace('{CONTENT}', $this->fields[$key] ?? '', $text);

            if ($key === 'model' || $key === 'resource') {
                $text = str_replace(
                    ['{RELATIONS_CONTENT}', '{IMPORTS_CONTENT}'],
                    [$this->fields[$key.'_relations'] ?? '', $this->fields[$key.'_imports'] ?? ''],
                    $text
                );
            }

            Storage::disk('packages')->put(
                $package . $folder . $value,
                $this->parseClassText($text)
            );
        }
    }


    /**
     * Replace all basic Info in Files Contents
     * @param string $text
     * @return array|string
     */
    private function parseClassText(string $text): array|string
    {
        $output = str_replace(
            array('{CLASS_NAME}', '{PACKAGE_NAME}', '{PACKAGE_PATH}', '{ITEM_NAME}', '{TABLE_NAME}'),
            array($this->crud, $this->package_name, $this->package_path, $this->crud_item, $this->table),
            $text
        );

        return "<?" . "php\n\n" . $output;
    }


    /**
     * Make All Fields of new CRUD
     * @return void
     */
    private function parseOptions(): void
    {
        foreach ($this->options as $optionKey => $optionValue) {
            foreach ($optionValue as $field) {
                $option = substr($optionKey, 0, -6);

                if ($optionKey === 'belongs-to') {
                    $data = $this->makeForeignField($field);
                } else if ($optionKey === 'has-many') {
                    $data = $this->makeHasManyField($field);
                } else {
                    $data = $this->makeAndCleanField($option, $field);
                }

                foreach ($data as $key => $value) {
                    if ($this->fields[$key] === '') {
                        $value = substr($value, 1);
                    }

                    $this->fields[$key] .= $value;
                }
            }
        }
    }


    /**
     * returns all FileNames of new CRUD
     * @return string[]
     */
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


    /**
     * Make and Cleanup Normal Field
     * @param string $option
     * @param string $field
     * @return array|string[]
     */
    private function makeAndCleanField(string $option, string $field): array
    {
        $data = $this->makeField($field, $option);
        return $this->cleanFieldData($option, $field, $data);
    }


    /**
     * Makes new Foreign Field
     * @param string $field
     * @return string[]
     */
    private function makeForeignField(string $field): array
    {
        $fieldClass = $field;
        $fieldExploded = explode('\\', $field);
        $field = strtolower(Arr::last($fieldExploded));

        $fieldName = $field.'_id';
        $tableName = Str::plural($field);

        $resourceName = ucfirst($field).'Resource';
        $resource = array_merge(array_slice($fieldExploded, 0, -2), ['Http', 'Resources', $resourceName]);
        $resource = implode("\\", $resource);

        $make = $this->makeField($fieldName, 'foreign');
        $make['model'] .= "\n * @property ".ucfirst($field)." \$$field";
        $make['resource'] .= "\n\t\t\t'".$field."' => $resourceName::make(\$this->whenLoaded('".$field."')),";

        unset($make['request_store'], $make['request_update'], $make['filter_scope']);

        return $make + [
            'request_store' => "\n\t\t\t'".$fieldName."' => ['required', 'int', 'exists:$tableName,id'],",
            'request_update' => "\n\t\t\t'".$fieldName."' => ['required', 'int', 'exists:$tableName,id'],",
            'resource_imports' => "\nuse $resource;",
            'filter_scope' => "\n\n\tpublic function $field(\$term): Builder
    {
        return \$this->builder->where('".$fieldName."', \$term);
    }",
            'load_scope' => "\n\n\tpublic function $field(): Builder
    {
        return \$this->builder->with('".$field."');
    }",
            'model_imports' => "\nuse $fieldClass;",
            'model_relations' => "\n\n\tpublic function $field(): BelongsTo
    {
        return \$this->belongsTo(".ucfirst($field)."::class);
    }",
        ];
    }


    /**
     * Makes new HasMany Relation
     * @param string $field
     * @return string[]
     */
    private function makeHasManyField(string $field): array
    {
        $fieldClass = $field;
        $fieldExploded = explode('\\', $field);
        $field = strtolower(Arr::last($fieldExploded));
        $fieldPlural = Str::plural($field);
        $fieldClassName = ucfirst($field);

        $resourceName = $fieldClassName.'Resource';
        $resource = array_merge(array_slice($fieldExploded, 0, -2), ['Http', 'Resources', $resourceName]);
        $resource = implode("\\", $resource);

        return [
            'resource' => "\n\t\t\t'".$fieldPlural."' => $resourceName::collection(\$this->whenLoaded('".$fieldPlural."')),",
            'resource_imports' => "\nuse $resource;",
            'filter_scope' => "\n\n\tpublic function has" . $fieldClassName . "(\$term): Builder
    {
        return \$this->builder->whereHas('".$fieldPlural."', function (Builder \$q) use (\$term) {
            \$q->where('id', \$term);
        });
    }",
            'load_scope' => "\n\n\tpublic function $fieldPlural(): Builder
    {
        return \$this->builder->with('".$fieldPlural."');
    }",
            'model' => "\n * @property $fieldClassName"."[] \$$fieldPlural",
            'model_imports' => "\nuse $fieldClass;",
            'model_relations' => "\n\n\tpublic function $fieldPlural(): HasMany
    {
        return \$this->hasMany($fieldClassName::class);
    }",
            ];
    }


    /**
     * Makes any Type of Field
     * @param string $fieldName
     * @param string $type
     * @return string[]
     */
    private function makeField(string $fieldName, string $type): array
    {
        $migrationFieldType = $this->getMigrationType($type);
        $modelFieldType = $this->getModelType($type);
        $requestFieldType = $this->getValidatorType($type);

        $migration = $type === 'foreign' ?
            "\$table->$migrationFieldType('".$fieldName."')->constrained();" :
            "\$table->$migrationFieldType('".$fieldName."');";

        return [
            'migration' => "\n\t\t\t".$migration,
            'model' => "\n * @property $modelFieldType \$$fieldName",
            'dto' => "\n\t\tpublic $modelFieldType \$$fieldName,",
            'resource' => "\n\t\t\t'".$fieldName."' => \$this->".$fieldName.",",
            'request_store' => "\n\t\t\t'".$fieldName."' => ['required', '$requestFieldType'],",
            'request_update' => "\n\t\t\t'".$fieldName."' => ['required', '$requestFieldType'],",
            'filter_scope' => "\n\n\tpublic function $fieldName(\$term): Builder
    {
        return \$this->builder->where('".$fieldName."', \$term);
    }"
        ];
    }


    private function cleanFieldData(string $option, string $field, array $data): array
    {
        if (in_array($option, ['string', 'text', 'date', 'datetime'])) {
            unset($data['filter_scope']);
            if ($option === 'date' || $option === 'datetime') {
                $data += ['filter_scope' => "\n\n\tpublic function $field(\$term): Builder
    {
        return \$this->builder->where('".$field."', '>=', \$term['from'])
            ->where('".$field."', '<=', \$term['to']);
    }"];
            }
        }

        return $data;
    }


    private function getMigrationType(string $type): string
    {
        return match ($type) {
            'int' => 'unsignedInteger',
            'foreign' => 'foreignId',
            'bool' => 'boolean',
            default => $type
        };
    }


    private function getModelType(string $type): string
    {
        return match ($type) {
            'date', 'datetime' => 'mixed',
            'uuid', 'text' => 'string',
            'foreign' => 'int',
            default => $type
        };
    }


    private function getValidatorType(string $type): string
    {
        return match ($type) {
            'text' => 'string',
            'bool' => 'boolean',
            'int' => 'integer',
            default => $type
        };
    }
}
