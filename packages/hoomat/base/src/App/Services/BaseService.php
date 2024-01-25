<?php

namespace Hoomat\Base\App\Services;

use Exception;
use Hoomat\Base\App\Interfaces\IDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected mixed $repository;


    /**
     * @throws Exception
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }


    /**
     * Get All Item
     */
    public function index()
    {
        return $this->repository->get();
    }


    /**
     * Get Single Item
     *
     * @param int $id
     * @return Model|Builder|null
     */
    public function show(int $id): Model|Builder|null
    {
        return $this->repository->getOne($id);
    }


    /**
     * Create new Item
     *
     * @param IDTO $dto
     * @return Model|Builder|null
     */
    public function create(IDTO $dto): Model|Builder|null
    {
       return $this->repository->create($dto);
    }


    /**
     * Update an Existing Item
     *
     * @param $item
     * @param IDTO $dto
     * @return Model|Builder|null
     */
    public function update($item, IDTO $dto): Model|Builder|null
    {
        return $this->repository->updateOne($item, $dto);
    }


    /**
     * Delete an Existing Item
     *
     * @param $item
     * @return bool
     */
    public function delete($item): bool
    {
        return $this->repository->deleteOne($item);
    }


    /**
     * Flush Model Cache
     *
     * @param $item
     * @return void
     */
    public function flushCache($item): void
    {
        $this->repository->flushCache($item);
    }
}
