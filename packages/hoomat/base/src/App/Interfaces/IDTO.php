<?php

namespace Hoomat\Base\App\Interfaces;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface IDTO extends Arrayable, \ArrayAccess
{
    public static function from(array $data): static;
    public static function fromArray(array $items, array $excepts = []): static;
    public static function fromCollection(Collection $collection, array $excepts = []): static;
    public static function fromRequest(FormRequest|Request $request, array $excepts = []): static;
    public function append($keys, $value = null): static;
}
