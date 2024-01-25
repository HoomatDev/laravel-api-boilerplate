<?php

namespace Hoomat\Filesystem\App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static upload()
 * @method static model($model): static
 * @method static user(int $userId): static
 * @method static fileable($fileable): static
 * @method static file($file): static
 * @method static alt(string $alt): static
 * @method static disk(string $disk): static
 * @method static dir(string $directory): static
 * @method static type(string $type): static
 */
class Uploader extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'file-upload';
    }
}
