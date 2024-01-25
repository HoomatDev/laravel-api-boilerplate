<?php

namespace Hoomat\Notifications\App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static send()
 * @method static receivers(array $receivers): static
 * @method static template(string $template_name): static
 * @method static business(int $business_id): static
 * @method static text(string $text): static
 * @method static params(array $params): static
 * @method static details(?array $details): static
 * @method static image($image): static
 * @method static type(string $type): static
 * @method static sendAt($send_at): static
 * @method static sendAfter(int $minutes): static
 */
class Notifier extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'send-notification';
    }
}
