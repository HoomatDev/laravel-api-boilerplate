<?php

namespace Hoomat\Identities\App\Models;

use Hoomat\Base\App\Helpers\QueryBuilder;
use Hoomat\Base\App\Interfaces\IModel;
use Hoomat\Base\App\Traits\HasDate;
use Hoomat\Base\App\Traits\HasEagerLoad;
use Hoomat\Base\App\Traits\HasFilter;
use Hoomat\Base\App\Traits\HasSearch;
use Hoomat\Base\App\Traits\HasSort;
use Hoomat\Filesystem\App\Traits\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property ?string $first_name
 * @property ?string $last_name
 * @property ?string $email
 * @property ?string $mobile
 * @property ?int $role_id
 * @property ?string $national_code
 * @property mixed $birth_date
 * @property bool $gender - 0 for female, 1 for male, there is no number 2 :)
 * @property ?string $full_name
 */
class User extends Authenticatable implements IModel
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasDate, HasFile, HasFilter, HasSort, HasSearch, HasEagerLoad;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'role_id',
        'national_code',
        'birth_date',
        'gender'
    ];


    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }


    public function getCacheTags(): array
    {
        return $this->cache_tags ?? [];
    }


    public function getFullNameAttribute(): ?string
    {
        return $this->first_name && $this->last_name ?
            $this->first_name . ' ' . $this->last_name :
            null;
    }
}
