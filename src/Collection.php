<?php

namespace EslamDev\Collection;

class Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];
    /**
     * The type of items in the collection.
     *
     */
    protected $itemsType = 'array';


    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items =  $this->isArray($items);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Add item to the collection.
     *
     * @param  mixed  $item
     * @return this
     */
    public function add($item)
    {
        $this->items[] = $this->isArray($item);

        return $this;
    }
    /**
     * count item in the collection.
     *
     * @return count
     */
    public function count()
    {
        return count($this->items);
    }
    /**
     * filter item in the collection.
     *
     * @param  callable  $callable
     * @return this
     */
    public function filter(callable $callable)
    {

        $this->items = array_filter($this->items, $callable);
        return $this;
    }
    /**
     * merge item in the collection.
     *
     * @param  mixed  $array
     * @return this
     */

    public function merge(array $array = [])
    {
        $array =  $this->isArray($array);;

        $this->items =  array_merge($this->items, $array);
        return $this;
    }

    /**
     * where item the collection.
     *
     * @param  string $key
     * @param  string|null  $operator
     * @param  string|null  $value
     * @return $this
     */
    public function where($key, $operator = null, $value = null)
    {
        if ($value == null and $operator == null) {
            $value = true;
            $operator = '==';
        }
        if ($value == null) {
            $value = $operator;
            $operator = '==';
        }
        $this->operatorForWhere($key, $operator, $value);
        return $this;
    }
    /**
     * Get an operator checker callback.
     *
     * @param  string $key
     * @param  string|null  $operator
     * @param  string|null  $value
     * @return void
     */
    private function operatorForWhere($key, $operator = null, $value = null)
    {
        $this->filter(function ($item) use ($key, $value, $operator) {
            switch ($operator) {
                case '!=':
                    return $item[$key] != $value;
                case '<':
                    return $item[$key] < $value;
                case '>':
                    return $item[$key] > $value;
                case '<=':
                    return $item[$key] <= $value;
                case '>=':
                    return $item[$key] >= $value;
                case '===':
                    return $item[$key] === $value;
                case '!==':
                    return $item[$key] !== $value;
                default:
                case '=':
                case '==':
                    return $item[$key] == $value;
            }
        });
    }

    /**
     * Filter items by selected key value pair.
     *
     * @param  string  $key
     * @param  mixed  $values
     * @return void
     */
    public function whereIn($key, array $values = [])
    {
        $this->filter(function ($item) use ($key, $values) {
            return in_array($item[$key], $values);
        });
    }
    /**
     * Filter items by selected key value pair.
     *
     * @param  string  $key
     * @param  mixed  $values
     * @return void
     */
    public function whereNotIn($key, array $values = [])
    {
        $this->filter(function ($item) use ($key, $values) {
            return !in_array($item[$key], $values);
        });
    }

    /**
     * Order by.
     * @param string $col
     * @param string $dir
     * @return this
     */
    function orderBy($col, $dir = 'asc')
    {
        $sort = [
            'asc' => SORT_ASC,
            'desc' => SORT_DESC,
        ];

        $dir = isset($sort[$dir]) ? $sort[$dir] : SORT_ASC;

        array_multisort(array_map(function ($item) use ($col) {
            return $item[$col];
        }, $this->items), $dir, $this->items);

        return $this;
    }
    /**
     * Verify that it's an array or convert to an array.
     *
     * @return this||array
     */
    private function isArray($items)
    {
        if (is_array($items)) {
            return $items;
        }
        return  json_decode(json_encode($items), true);
    }
    /**
     * first item the collection.
     *
     * @return this||void
     */
    public function first()
    {
        if (is_array($this->items)) {
            return $this->items[0];
        }
        return null;
    }
    /**
     * get items the collection.
     *
     * @return this items
     */
    public function get()
    {
        return $this->items;
    }
    /**
     * get items the collection.
     *
     * @return object
     */
    public function toObject()
    {
        return json_decode(json_encode($this->items));
    }
    /**
     * get items the collection.
     *
     * @return array
     */
    public function toArray()
    {
        return  $this->isArray($this->items);
    }
}
