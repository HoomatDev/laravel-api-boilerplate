<?php

namespace Hoomat\Notifications\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use Hoomat\Notifications\App\Models\NotificationTemplate;
use Hoomat\Notifications\App\Repositories\Interfaces\NotificationTemplateRepositoryInterface;
use Hoomat\Notifications\App\Scopes\NotificationTemplate\NotificationTemplateFilterScope;
use Hoomat\Notifications\App\Scopes\NotificationTemplate\NotificationTemplateLoadScope;
use Hoomat\Notifications\App\Scopes\NotificationTemplate\NotificationTemplateSearchScope;
use Hoomat\Notifications\App\Scopes\NotificationTemplate\NotificationTemplateSortScope;

class NotificationTemplateRepository extends BaseRepository implements NotificationTemplateRepositoryInterface
{
    public function __construct(
        NotificationTemplate $model,
        NotificationTemplateFilterScope $filterScope,
        NotificationTemplateSortScope $sortScope,
        NotificationTemplateSearchScope $searchScope,
        NotificationTemplateLoadScope $loadScope
    )
    {
        parent::__construct($model, $filterScope, $sortScope, $searchScope, $loadScope);
    }
}
