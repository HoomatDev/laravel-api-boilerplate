<?php

namespace Hoomat\Base\App\Repositories\Interfaces;

use Hoomat\Base\App\Interfaces\IDTO;
use Hoomat\Base\App\Interfaces\IModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function get();

    public function getWithWhere(array $where): Collection|array;

    public function getOne(int $id): Model|Collection|Builder|array|null;

    public function getFilteredOne(array $filters = []): Model|Builder|null;

    public function getFirst(): Model|Builder|null;

    public function getLast(): Model|Builder|null;

    public function create(IDTO $dto): Model|Builder|null;

    public function updateOne(mixed $item, IDTO $dto): mixed;

    public function firstOrCreateOne(mixed $conditions, IDTO $values): Model|Builder|bool;

    public function updateOrCreateOne(mixed $conditions, IDTO $values): Model|Builder|bool;

    public function deleteOne($item): bool;

    public function getModel(): IModel;

    public function getModelName(): string;
}
