<?php

use EslamDev\Collection\Collection;

if (!function_exists('collect')) {
    function collect($items = null): Collection
    {
        return new Collection($items);
    }
}
