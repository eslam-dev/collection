<?php

use EslamDev\Collection\Collection;

if (!function_exists('collect')) {
    function collect($items = null)
    {
        return new Collection($items);
    }
}
