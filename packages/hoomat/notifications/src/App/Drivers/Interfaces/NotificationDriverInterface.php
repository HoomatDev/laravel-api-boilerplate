<?php

namespace Hoomat\Notifications\App\Drivers\Interfaces;

interface NotificationDriverInterface
{
    public function send();

    public function from(string $from): static;

    public function to(array|string $receivers): static;

    public function text(string $text): static;

    public function details(array $details): static;
}
