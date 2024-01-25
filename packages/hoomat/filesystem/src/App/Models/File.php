<?php

namespace Hoomat\Filesystem\App\Models;

use Hoomat\Base\App\Models\BaseModel;
use Hoomat\Identities\App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $fileable_type
 * @property int $fileable_id
 * @property ?string $alt
 * @property string $name
 * @property string $directory
 * @property string $disk
 * @property string $type
 * @property string $path
 * @property User $user
 */
class File extends BaseModel
{
    protected $fillable = [
        'user_id',
        'fileable_type',
        'fileable_id',
        'alt',
        'name',
        'disk',
        'directory',
        'type',
    ];


    public function getPathAttribute(): string
    {
        return $this->directory.'/'.$this->type.'/'.$this->name;
    }


    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
