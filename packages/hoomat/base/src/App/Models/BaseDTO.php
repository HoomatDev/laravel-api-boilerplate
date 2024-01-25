<?php

namespace Hoomat\Base\App\Models;

use Hoomat\Base\App\Interfaces\IDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use ReflectionClass;

abstract class BaseDTO implements IDTO
{
    public static function from(array $data): static
    {
        $obj = new ReflectionClass(static::class);
        $keys = $obj->getProperties();
        $args = [];
        foreach ($keys as $key) {
            $key = $key->name;
            $args[$key] = isset($data[$key]) ? $data[$key] : null;
        }

        return $obj->newInstanceArgs($args);
    }

    public static function fromModel($item, ?array $data = null)
    {
        $values = $item->attributesToArray();
        if($data){
            $values = array_merge($values, $data);
        }

        return self::from($values);
    }

    public static function fromArray(array $items, array $excepts = []): static
    {
        $items = Arr::except($items, $excepts);
        return self::from($items);
    }

    public static function fromCollection(Collection $collection, array $excepts = []): static
    {
        $items = empty($excepts) ? $collection->all() : $collection->except($excepts);
        return self::from($items);
    }

    public static function fromRequest(FormRequest|Request $request, array $excepts = []): static
    {
        $items = empty($excepts) ? $request->all() : $request->except($excepts);
        return self::from($items);
    }

    public function append($keys, $value = null): static
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->$key = $value;
            }
            return $this;
        }
        $this->$keys = $value;
        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->$offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }
}
