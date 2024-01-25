<?php

namespace Hoomat\Identities\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class RoleDTO extends BaseDTO
{
    public function __construct(public string $name)
    {}
}
