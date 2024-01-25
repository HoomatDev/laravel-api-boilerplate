<?php

namespace Hoomat\Identities\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class PermissionDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $key
    )
    {}
}
