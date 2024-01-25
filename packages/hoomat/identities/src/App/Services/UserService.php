<?php

namespace Hoomat\Identities\App\Services;

use Hoomat\Base\App\Services\BaseService;
use Hoomat\Identities\App\Models\DTOs\UserDTO;
use Hoomat\Identities\App\Repositories\Interfaces\UserRepositoryInterface;

class UserService extends BaseService
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }


    public function createWithSocial(UserDTO $dto)
    {
        return $this->repository->firstOrCreateOne([
            'email' => $dto->email
        ], $dto);
    }


    public function getOrCreate(string $field, string $value)
    {
        $dto = $field === 'mobile' ? new UserDTO(mobile: $value) : new UserDTO(email: $value);
        return $this->repository->firstOrCreateOne(
            [$field => $value],
            $dto
        );
    }
}
