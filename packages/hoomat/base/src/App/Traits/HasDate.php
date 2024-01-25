<?php

namespace Hoomat\Base\App\Traits;

use Hoomat\Base\App\Helpers\Utility;

trait HasDate
{
    public function getCreatedAt()
    {
        return Utility::convertDate($this->created_at);
    }

    public function getUpdatedAt()
    {
        return Utility::convertDate($this->updated_at);
    }
}
