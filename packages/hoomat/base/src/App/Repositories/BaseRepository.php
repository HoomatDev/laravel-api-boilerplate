<?php

namespace Hoomat\Base\App\Repositories;

use Hoomat\Base\App\Interfaces\IDTO;
use Hoomat\Base\App\Interfaces\IModel;
use Hoomat\Base\App\Repositories\Interfaces\EloquentRepositoryInterface;
use Hoomat\Base\App\Scopes\EagerLoadScope;
use Hoomat\Base\App\Scopes\FilterScope;
use Hoomat\Base\App\Scopes\SearchScope;
use Hoomat\Base\App\Scopes\SortScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param IModel          $model
     * @param FilterScope    $filterScope
     * @param SortScope      $sortScope
     * @param SearchScope    $searchScope
     * @param EagerLoadScope $loadScope
     */
    public function __construct(
        protected readonly IModel $model,
        private FilterScope       $filterScope,
        private SortScope         $sortScope,
        private SearchScope       $searchScope,
        private EagerLoadScope    $loadScope,
    )
    {
    }


    /**
     * Get All Items
     */
    public function get()
    {
        return $this->model
            ->query()
            ->eagerLoad($this->loadScope)
            ->filter($this->filterScope)
            ->normalSearch($this->searchScope)
            ->sort($this->sortScope)
            ->decide();
    }


    /**
     * Get All Items From Cache of Model
     *
     * @param array $where
     * @return Collection|array
     */
    public function getWithWhere(array $where): Collection|array
    {
        return $this->model
            ->query()
            ->eagerLoad($this->loadScope)
            ->where($where)
            ->filter($this->filterScope)
            ->normalSearch($this->searchScope)
            ->sort($this->sortScope)
            ->get();
    }


    /**
     * Find One Item of Model With ID
     *
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getOne(int $id): Model|Collection|Builder|array|null
    {
        return $this->model
            ->query()
            ->eagerLoad($this->loadScope)
            ->find($id);
    }


    /**
     * Get One Item of Model with Custom Filters
     *
     * @param array $filters
     * @return Model|Builder|null
     */
    public function getFilteredOne(array $filters = []): Model|Builder|null
    {
        return $this->model
            ->query()
            ->eagerLoad($this->loadScope)
            ->where($filters)
            ->latest()
            ->first();
    }


    /**
     * Get First Item of Model
     *
     * @return Model|Builder|null
     */
    public function getFirst(): Model|Builder|null
    {
        return $this->model
            ->query()
            ->eagerLoad($this->loadScope)
            ->first();
    }


    /**
     * Get Last Item of Model
     *
     * @return Model|Builder|null
     */
    public function getLast(): Model|Builder|null
    {
        return $this->model
            ->query()
            ->eagerLoad($this->loadScope)
            ->latest()
            ->first();
    }


    /**
     * Create New Item with Model's DTO
     *
     * @param IDTO $dto
     * @return Builder|Model|null
     */
    public function create(IDTO $dto): Model|Builder|null
    {
        try {
            return $this->model->query()->create($dto->toArray());
        } catch (\Throwable $th) {
            Log::error($th);
            return null;
        }
    }


    /**
     * Update an Existing Item with Model's DTO
     *
     * @param mixed $item
     * @param IDTO  $dto
     * @return mixed|null
     */
    public function updateOne(mixed $item, IDTO $dto): mixed
    {
        try {
            $item->update($dto->toArray());

            return $item;
        } catch (\Throwable $th) {
            Log::error($th);
            return null;
        }
    }


    /**
     * Find or Create Item with Conditions and Model's DTO
     *
     * @param mixed $conditions
     * @param IDTO  $values
     * @return Model|Builder|bool
     */
    public function firstOrCreateOne(mixed $conditions, IDTO $values): Model|Builder|bool
    {
        try {
            return $this->model->query()->firstOrCreate(
                $conditions,
                $values->toArray()
            );
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     * Update or Create Item with Conditions and Model's DTO
     *
     * @param mixed $conditions
     * @param IDTO  $values
     * @return Model|Builder|bool
     */
    public function updateOrCreateOne(mixed $conditions, IDTO $values): Model|Builder|bool
    {
        try {
            return $this->model->query()->updateOrCreate(
                $conditions,
                $values->toArray()
            );
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     * Delete an Existing Item
     *
     * @param $item
     * @return bool
     */
    public function deleteOne($item): bool
    {
        try {
            $item->delete();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     * Get Current Model
     *
     * @return IModel
     */
    public function getModel(): IModel
    {
        return $this->model;
    }


    /**
     * Get Current Model Class Namespace+Name
     *
     * @return string
     */
    public function getModelName(): string
    {
        return get_class($this->model);
    }
}
