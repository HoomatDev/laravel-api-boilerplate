<?php

namespace Hoomat\Filesystem\App\Traits;

use Hoomat\Filesystem\App\Models\File;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFile
{
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }


    public function getFileUrl($type): string
    {
        $file = $this->files->where('type', $type)->first();

        return $file ? config('app.cdn_url').'/'.$file->path : '';
    }
}
