<?php

namespace Hoomat\Notifications\App\Services;

use Hoomat\Base\App\Services\BaseService;
use Hoomat\Notifications\App\Repositories\Interfaces\NotificationTemplateRepositoryInterface;

class NotificationTemplateService extends BaseService
{
    public function __construct(
        NotificationTemplateRepositoryInterface $repository
    )
    {
        parent::__construct($repository);
    }


    public function findByName(string $name)
    {
        return $this->repository->getFilteredOne(['name' => $name]);
    }
}
