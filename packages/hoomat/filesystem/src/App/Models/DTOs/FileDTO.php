<?php

namespace Hoomat\Filesystem\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class FileDTO extends BaseDTO
{
    public function __construct(
        public ?int $user_id,
        public string $fileable_type,
        public int $fileable_id,
        public ?string $alt,
        public string $disk,
        public string $name,
        public string $directory,
        public string $type
    )
    {
        $this->user_id = $this->user_id ?? auth('sanctum')->id();
    }
}
