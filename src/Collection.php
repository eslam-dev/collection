<?php

namespace EslamDev\Collection;

use InvalidArgumentException;
use IteratorAggregate;
use ArrayIterator;

/**
 * Class Collection
 * A flexible and extensible collection handler.
 */
class Collection implements IteratorAggregate
{
    protected array $items = [];
    protected string $itemsType = 'array';

    /**
     * Constructor
     * @param iterable|array $items
     */
    public function __construct(iterable $items = [])
    {
        $this->items = $this->toArray($items);
    }

    /**
     * Get all items in the collection.
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Add an item to the collection.
     * @param mixed $item
     * @return self
     */
    public function add(mixed $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Count items in the collection.
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Filter items based on a callback.
     * @param callable $callback
     * @return self
     */
    public function filter(callable $callback): self
    {
        $this->items = array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH);
        return $this;
    }

    /**
     * Map items using a callback.
     * @param callable $callback
     * @return self
     */
    public function map(callable $callback): self
    {
        $this->items = array_map($callback, $this->items);
        return $this;
    }

    /**
     * Merge another array or iterable into the collection.
     * @param array $array
     * @return self
     */
    public function merge(array $array): self
    {
        $this->items = array_merge($this->items, $this->toArray($array));
        return $this;
    }

    /**
     * Select specific keys from items.
     * @param string|string[] $keys
     * @return self
     */
    public function select(string|array $keys): self
    {
        $this->items = array_map(function ($item) use ($keys) {
            $keys = (array)$keys;
            return array_intersect_key($item, array_flip($keys));
        }, $this->items);
        return $this;
    }

    /**
     * Filter items by a key and value condition.
     * @param string $key
     * @param string|null $operator
     * @param mixed|null $value
     * @return self
     */
    public function where(string $key, string $operator = null, mixed $value = null): self
    {
        if ($value === null && $operator === null) {
            $value = true;
            $operator = '==';
        }
        if ($value === null) {
            $value = $operator;
            $operator = '==';
        }

        $this->operatorForWhere($key, $operator, $value);
        return $this;
    }

    /**
     * Filter items based on a specific operator.
     * @param string $key
     * @param string $operator
     * @param mixed $value
     */
    private function operatorForWhere(string $key, string $operator, mixed $value): void
    {
        $this->filter(function ($item) use ($key, $value, $operator) {
            $itemValue = $item[$key] ?? null;

            switch ($operator) {
                case '!=':
                    return $itemValue != $value;
                case '<':
                    return $itemValue < $value;
                case '>':
                    return $itemValue > $value;
                case '<=':
                    return $itemValue <= $value;
                case '>=':
                    return $itemValue >= $value;
                case '===':
                    return $itemValue === $value;
                case '!==':
                    return $itemValue !== $value;
                default:
                case '=':
                case '==':
                    return $itemValue == $value;
            }
        });
    }

    /**
     * Filter items by a set of values.
     * @param string $key
     * @param array $values
     * @return self
     */
    public function whereIn(string $key, array $values): self
    {
        $this->filter(function ($item) use ($key, $values) {
            return in_array($item[$key] ?? null, $values);
        });
        return $this;
    }

    /**
     * Exclude items by a set of values.
     * @param string $key
     * @param array $values
     * @return self
     */
    public function whereNotIn(string $key, array $values): self
    {
        $this->filter(function ($item) use ($key, $values) {
            return !in_array($item[$key] ?? null, $values);
        });
        return $this;
    }

    /**
     * Update items that match a condition.
     * @param array $data
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function update(array $data, string $key, mixed $value): self
    {
        $this->items = array_map(function ($item) use ($data, $key, $value) {
            if (($item[$key] ?? null) == $value) {
                return array_merge($item, $data);
            }
            return $item;
        }, $this->items);

        return $this;
    }

    /**
     * Delete items that match a condition.
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function delete(string $key, mixed $value): self
    {
        $this->items = array_filter($this->items, function ($item) use ($key, $value) {
            return ($item[$key] ?? null) != $value;
        });

        return $this;
    }

    /**
     * Sort the collection by a column.
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        usort($this->items, function ($a, $b) use ($column, $direction) {
            return $direction === 'asc'
                ? $a[$column] <=> $b[$column]
                : $b[$column] <=> $a[$column];
        });
        return $this;
    }
    /**
     * Chunk the collection into arrays of the specified size.
     * @param int $size
     * @return array
     */
    public function chunk(int $size): array
    {
        if ($size <= 0) {
            throw new InvalidArgumentException("Chunk size must be greater than 0.");
        }

        return array_chunk($this->items, $size);
    }
    /**
     * Check if the collection contains a specific value.
     * @param mixed $value
     * @param string|null $key
     * @return bool
     */
    public function contains(mixed $value, string $key = null): bool
    {
        if ($key === null) {
            return in_array($value, $this->items, true);
        }

        foreach ($this->items as $item) {
            if (($item[$key] ?? null) === $value) {
                return true;
            }
        }

        return false;
    }
    /**
     * Group the collection by a given key.
     * @param string $key
     * @return array
     */
    public function groupBy(string $key): array
    {
        $grouped = [];

        foreach ($this->items as $item) {
            $groupValue = $item[$key] ?? null;
            $grouped[$groupValue][] = $item;
        }

        return $grouped;
    }
    /**
     * Get the values of a specific key from all items.
     * @param string $key
     * @return array
     */
    public function pluck(string $key): array
    {
        return array_map(function ($item) use ($key) {
            return $item[$key] ?? null;
        }, $this->items);
    }
    /**
     * Reduce the collection to a single value using a callback.
     * @param callable $callback
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }
    /**
     * Reverse the order of the items in the collection.
     * @return self
     */
    public function reverse(): self
    {
        $this->items = array_reverse($this->items);
        return $this;
    }
    /**
     * Get unique items in the collection based on a key.
     * @param string|null $key
     * @return self
     */
    public function unique(string $key = null): self
    {
        if ($key === null) {
            $this->items = array_unique($this->items, SORT_REGULAR);
        } else {
            $seen = [];
            $this->items = array_filter($this->items, function ($item) use ($key, &$seen) {
                $value = $item[$key] ?? null;
                if (in_array($value, $seen, true)) {
                    return false;
                }
                $seen[] = $value;
                return true;
            });
        }

        return $this;
    }
    /**
     * Check if the collection is empty.
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
    /**
     * Convert the collection to JSON.
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->items, JSON_PRETTY_PRINT);
    }
    /**
     * Execute a callback over each item.
     * @param callable $callback
     * @return self
     */
    public function each(callable $callback): self
    {
        foreach ($this->items as $key => $item) {
            $callback($item, $key);
        }
        return $this;
    }

    /**
     * Filter items using a pattern.
     * @param string $key
     * @param string $pattern
     * @return self
     */
    public function like(string $key, string $pattern): self
    {
        $regex = '/^' . str_replace('%', '.*', preg_quote($pattern, '/')) . '$/i';
        $this->filter(function ($item) use ($key, $regex) {
            return isset($item[$key]) && preg_match($regex, $item[$key]);
        });
        return $this;
    }

    /**
     * Get the first item.
     * @return mixed|null
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    /**
     * Get the last item.
     * @return mixed|null
     */
    public function last(): mixed
    {
        return end($this->items) ?: null;
    }

    /**
     * Get all items in the collection (alias of all).
     * @return array
     */
    public function get(): array
    {
        return $this->all();
    }

    /**
     * Convert items to an object.
     * @return object
     */
    public function toObject(): object
    {
        return json_decode(json_encode($this->items));
    }

    /**
     * Convert items to an array.
     * @param iterable $items
     * @return array
     */
    private function toArray(iterable $items): array
    {
        if (is_array($items)) {
            return $items;
        }

        if ($items instanceof \Traversable) {
            return iterator_to_array($items);
        }

        throw new InvalidArgumentException("Items must be an array or iterable.");
    }

    /**
     * Get an iterator for the collection.
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
