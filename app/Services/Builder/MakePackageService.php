<?php

namespace App\Services\Builder;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakePackageService
{
    private string $package;
    private string $package_path;
    private string $package_namespace;
    private string $package_name;
    private string $package_api;


    public function make(string $package): void
    {
        $this->package = $package;

        $package_arr = explode('/', $package);
        $path = '';
        $namespace = '';
        foreach ($package_arr as $name) {
            $path .= ucfirst($name) . '\\';
            $namespace .= ucfirst($name) . '\\\\';
        }
        $this->package_path = substr($path, 0, -1);
        $this->package_namespace = substr($namespace, 0, -1);

        $this->package_name = ucfirst(Arr::last($package_arr));
        $this->package_api = strtolower(Str::plural(Arr::last($package_arr)));

        foreach ($this->getConfig() as $key => $value) {
            $isPHP = !($key === 'composer');

            if (is_null($value)) {
                Storage::disk('packages')->makeDirectory($package . '/' . $key);
            } else {
                Storage::disk('packages')->put(
                    $package . '/' . $value,
                    $this->parseClassText(config("builder.package_texts.$key"), $isPHP)
                );
            }
        }
    }


    private function parseClassText($text, bool $isPHP): array|string
    {
        $output = str_replace(
            array('{PACKAGE}', '{PACKAGE_NAME}', '{PACKAGE_PATH}', '{PACKAGE_NAMESPACE}', '{PACKAGE_API}'),
            array($this->package, $this->package_name, $this->package_path, $this->package_namespace, $this->package_api),
            $text
        );

        return $isPHP ? "<?" . "php

" . $output : $output;
    }


    private function getConfig(): array
    {
        return [
            'composer' => "composer.json",
            'app_provider' => "src/Providers/$this->package_name" . "ServiceProvider.php",
            'repository_provider' => "src/Providers/RepositoryServiceProvider.php",
            'config' => "src/config/$this->package_name" . 'Config.php',
            'routes' => "src/App/Http/routes/api.php",

            'database/migrations' => null,
            'src/App/Http/Controllers' => null,
            'src/App/Http/Requests' => null,
            'src/App/Http/Resources' => null,
            'src/App/Scopes' => null,
            'src/App/Models/DTOs' => null,
            'src/App/Repositories/Interfaces' => null,
            'src/App/Services' => null,
        ];
    }
}
