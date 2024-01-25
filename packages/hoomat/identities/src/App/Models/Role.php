<?php

namespace Hoomat\Identities\App\Models;

use Hoomat\Base\App\Models\BaseModel;
use Hoomat\Base\App\Traits\HasDate;
use Hoomat\Services\App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property User[] $users
 * @property Permission[] $permissions
 */
class Role extends BaseModel
{
    use HasDate;

    protected $fillable = [
        'name'
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
