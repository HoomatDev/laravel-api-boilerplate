<?php

return [

    'package_texts' => [
        'composer' => '{
    "name": "{PACKAGE}",
    "description": "",
    "type": "library",
    "license": "MIT",
    "authors": [
        {
            "name": "Alireza Rahimi",
            "email": "alireza.rahimi.dev@gmail.com"
        }
    ],
    "minimum-stability": "dev",
    "autoload": {
        "psr-4": {
            "{PACKAGE_NAMESPACE}\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "{PACKAGE_NAMESPACE}\\Providers\\\{PACKAGE_NAME}ServiceProvider"
            ]
        }
    },
    "require": {}
}',

        'repository_provider' => "namespace {PACKAGE_PATH}\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // \$this->app->bind(Interface::class, Repository::class);
    }
}
",

        'app_provider' => "namespace {PACKAGE_PATH}\Providers;

use Illuminate\Support\ServiceProvider;

class {PACKAGE_NAME}ServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        \$this->mergeConfigFrom(__DIR__.'/../config/{PACKAGE_NAME}Config.php', '{PACKAGE_NAME}Config');

        \$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        \$this->loadRoutesFrom(__DIR__.'/../App/Http/routes/api.php');
    }

    public function register(): void
    {
        \$this->app->register(RepositoryServiceProvider::class);
    }
}",

        'config' => "return [
    'prefix' => 'api/{PACKAGE_API}',

    'middleware' => ['api'],
];",

        'routes' => "use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('{PACKAGE_NAME}Config.prefix'),
    'middleware' => config('{PACKAGE_NAME}Config.middleware')
], function() {

});"
    ],


    'crud_texts' => [
        'migration' => "use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{TABLE_NAME}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{TABLE_NAME}');
    }
};",

        'model' => "namespace {PACKAGE_PATH}\App\Models;

use Hoomat\Base\App\Models\BaseModel;
use Hoomat\Base\App\Traits\HasDate;
use Hoomat\Base\App\Traits\HasEagerLoad;
use Hoomat\Base\App\Traits\HasFilter;
use Hoomat\Base\App\Traits\HasSearch;
use Hoomat\Base\App\Traits\HasSort;

/**
 * @property int \$id
 */
class {CLASS_NAME} extends BaseModel
{
    use HasDate, HasFilter, HasSearch, HasSort, HasEagerLoad;

    protected \$fillable = [];
}",

        'dto' => "namespace {PACKAGE_PATH}\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class {CLASS_NAME}DTO extends BaseDTO
{
    public function __construct(
    )
    {}
}",

        'repository_interface' => "namespace {PACKAGE_PATH}\App\Repositories\Interfaces;

use Hoomat\Base\App\Repositories\Interfaces\EloquentRepositoryInterface;

interface {CLASS_NAME}RepositoryInterface extends EloquentRepositoryInterface
{
}",

        'repository' => "namespace {PACKAGE_PATH}\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use {PACKAGE_PATH}\App\Models\{CLASS_NAME};
use {PACKAGE_PATH}\App\Repositories\Interfaces\{CLASS_NAME}RepositoryInterface;
use {PACKAGE_PATH}\App\Scopes\{CLASS_NAME}\{CLASS_NAME}FilterScope;
use {PACKAGE_PATH}\App\Scopes\{CLASS_NAME}\{CLASS_NAME}LoadScope;
use {PACKAGE_PATH}\App\Scopes\{CLASS_NAME}\{CLASS_NAME}SearchScope;
use {PACKAGE_PATH}\App\Scopes\{CLASS_NAME}\{CLASS_NAME}SortScope;

class {CLASS_NAME}Repository extends BaseRepository implements {CLASS_NAME}RepositoryInterface
{
    public function __construct(
        {CLASS_NAME} \$model,
        {CLASS_NAME}FilterScope \$filterScope,
        {CLASS_NAME}SortScope \$sortScope,
        {CLASS_NAME}SearchScope \$searchScope,
        {CLASS_NAME}LoadScope \$loadScope,
    )
    {
        parent::__construct(\$model, \$filterScope, \$sortScope, \$searchScope, \$loadScope);
    }
}",

        'filter_scope' => "namespace {PACKAGE_PATH}\App\Scopes\{CLASS_NAME};

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class {CLASS_NAME}FilterScope extends FilterScope
{
}",

        'load_scope' => "namespace {PACKAGE_PATH}\App\Scopes\{CLASS_NAME};

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Illuminate\Database\Eloquent\Builder;

class {CLASS_NAME}LoadScope extends EagerLoadScope
{
}",

        'sort_scope' => "namespace {PACKAGE_PATH}\App\Scopes\{CLASS_NAME};

use Hoomat\Base\App\Scopes\SortScope;
use Illuminate\Database\Eloquent\Builder;

class {CLASS_NAME}SortScope extends SortScope
{
    public function created_at(\$term): Builder
    {
        return \$this->builder->orderBy('created_at', \$term);
    }
}",

        'search_scope' => "namespace {PACKAGE_PATH}\App\Scopes\{CLASS_NAME};

use Hoomat\Base\App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Builder;

class {CLASS_NAME}SearchScope extends SearchScope
{
}",

        'service' => "namespace {PACKAGE_PATH}\App\Services;

use Hoomat\Base\App\Services\BaseService;
use {PACKAGE_PATH}\App\Repositories\Interfaces\{CLASS_NAME}RepositoryInterface;

class {CLASS_NAME}Service extends BaseService
{
    public function __construct({CLASS_NAME}RepositoryInterface \$repository)
    {
        parent::__construct(\$repository);
    }
}",

        'resource' => "namespace {PACKAGE_PATH}\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class {CLASS_NAME}Resource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
        ];
    }
}",

        'request_index' => "namespace {PACKAGE_PATH}\App\Http\Requests\{CLASS_NAME};

use Illuminate\Foundation\Http\FormRequest;

class {CLASS_NAME}IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }
}",

        'request_store' => "namespace {PACKAGE_PATH}\App\Http\Requests\{CLASS_NAME};

use Illuminate\Foundation\Http\FormRequest;

class {CLASS_NAME}StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }
}",

        'request_update' => "namespace {PACKAGE_PATH}\App\Http\Requests\{CLASS_NAME};

use Illuminate\Foundation\Http\FormRequest;

class {CLASS_NAME}UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }
}",

        'policy' => "namespace {PACKAGE_PATH}\App\Policies;

use Hoomat\Base\App\Helpers\Utility;
use Hoomat\Identities\App\Models\User;
use {PACKAGE_PATH}\App\Models\{CLASS_NAME};
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class {CLASS_NAME}Policy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  \$user
     * @return Response|bool
     */
    public function viewAny(User \$user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  \$user
     * @param  {CLASS_NAME}  \${ITEM_NAME}
     * @return Response|bool
     */
    public function view(User \$user, {CLASS_NAME} \${ITEM_NAME})
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  \$user
     * @return Response|bool
     */
    public function create(User \$user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  \$user
     * @param  {CLASS_NAME}  \${ITEM_NAME}
     * @return Response|bool
     */
    public function update(User \$user, {CLASS_NAME}  \${ITEM_NAME})
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  \$user
     * @param  {CLASS_NAME}  \${ITEM_NAME}
     * @return Response|bool
     */
    public function delete(User \$user, {CLASS_NAME}  \${ITEM_NAME})
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  \$user
     * @param  {CLASS_NAME}  \${ITEM_NAME}
     * @return Response|bool
     */
    public function restore(User \$user, {CLASS_NAME}  \${ITEM_NAME})
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  \$user
     * @param  {CLASS_NAME}  \${ITEM_NAME}
     * @return Response|bool
     */
    public function forceDelete(User \$user, {CLASS_NAME}  \${ITEM_NAME})
    {
        //
    }
}",

        'controller' => "namespace {PACKAGE_PATH}\App\Http\Controllers;

use Hoomat\Base\App\Http\Controllers\Controller;
use {PACKAGE_PATH}\App\Models\{CLASS_NAME};
use {PACKAGE_PATH}\App\Models\DTOs\{CLASS_NAME}DTO;
use {PACKAGE_PATH}\App\Http\Requests\{CLASS_NAME}\{CLASS_NAME}IndexRequest;
use {PACKAGE_PATH}\App\Http\Requests\{CLASS_NAME}\{CLASS_NAME}StoreRequest;
use {PACKAGE_PATH}\App\Http\Requests\{CLASS_NAME}\{CLASS_NAME}UpdateRequest;
use {PACKAGE_PATH}\App\Http\Resources\{CLASS_NAME}Resource;
use {PACKAGE_PATH}\App\Services\{CLASS_NAME}Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

/**
 * @group {PACKAGE_PATH}
 * @subgroup {CLASS_NAME}
 */
class {CLASS_NAME}Controller extends Controller
{
    public function __construct(
        private readonly {CLASS_NAME}Service \${ITEM_NAME}Service
    )
    {}


    /**
     * {CLASS_NAME} Index
     *
     * @param {CLASS_NAME}IndexRequest \$request
     * @return JsonResponse
     */
    public function index({CLASS_NAME}IndexRequest \$request): JsonResponse
    {
        Gate::authorize('viewAny', [{CLASS_NAME}::class]);
        \$items = \$this->{ITEM_NAME}Service->index();
        return \$this->dynamicResponse(\$items, {CLASS_NAME}Resource::class);
    }


    /**
     * {CLASS_NAME} Single
     *
     * @param {CLASS_NAME} \${ITEM_NAME}
     * @return JsonResponse
     */
    public function show({CLASS_NAME} \${ITEM_NAME}): JsonResponse
    {
        Gate::authorize('view', \${ITEM_NAME});
        \$item = \$this->{ITEM_NAME}Service->show(\${ITEM_NAME}->id);
        return \$this->dynamicResponse(\$item, {CLASS_NAME}Resource::class);
    }


    /**
     * {CLASS_NAME} Store
     *
     * @param {CLASS_NAME}StoreRequest \$request
     * @return JsonResponse
     */
    public function store({CLASS_NAME}StoreRequest \$request): JsonResponse
    {
        Gate::authorize('create', [{CLASS_NAME}::class]);
        \$item = \$this->{ITEM_NAME}Service->create({CLASS_NAME}DTO::fromRequest(\$request));
        \$item = \$this->{ITEM_NAME}Service->show(\$item->id);
        return \$this->dynamicResponse(\$item, {CLASS_NAME}Resource::class);
    }


    /**
     * {CLASS_NAME} Update
     *
     * @param {CLASS_NAME}UpdateRequest \$request
     * @param {CLASS_NAME} \${ITEM_NAME}
     * @return JsonResponse
     */
    public function update({CLASS_NAME}UpdateRequest \$request, {CLASS_NAME} \${ITEM_NAME}): JsonResponse
    {
        Gate::authorize('update', \${ITEM_NAME});
        \$this->{ITEM_NAME}Service->update(\${ITEM_NAME}, {CLASS_NAME}DTO::fromModel(\${ITEM_NAME}, \$request->all()));
        \$item = \$this->{ITEM_NAME}Service->show(\${ITEM_NAME}->id);
        return \$this->dynamicResponse(\$item, {CLASS_NAME}Resource::class);
    }


    /**
     * {CLASS_NAME} Delete
     *
     * @param {CLASS_NAME} \${ITEM_NAME}
     * @return JsonResponse
     */
    public function destroy({CLASS_NAME} \${ITEM_NAME}): JsonResponse
    {
        Gate::authorize('delete', \${ITEM_NAME});
        \$this->{ITEM_NAME}Service->delete(\${ITEM_NAME});
        return \$this->successResponse();
    }
}"
    ]
];
