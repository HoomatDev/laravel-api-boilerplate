<?php

namespace Hoomat\Identities\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class UserDTO extends BaseDTO
{
    public function __construct(
        public ?int $role_id = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $email = null,
        public ?string $mobile = null,
        public ?string $national_code = null,
        public mixed $birth_date = null,
        public bool $gender = true,
    )
    {}
}
