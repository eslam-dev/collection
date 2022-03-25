<h1 align="center">eslam-dev/collection</h1>

<p align="center">
    <strong>A PHP library for representing and manipulating collections.</strong>
</p>

## About

eslam-dev/collection is a PHP library for representing and manipulating collections.

## Installation

Install this package as a dependency using [Composer](https://getcomposer.org).

```bash
composer require eslam-dev/collection
```

## Usage

### Generic Collection

the collect helper returns a new EslamDev\Collection instance for the given array. So, creating a collection is as simple as:

```php

$collect = collect([
    ['id' => 1, 'name' => 'admin'   , 'type' => 'admin'],
    ['id' => 2, 'name' => 'admin 2' , 'type' => 'admin'],
    ['id' => 3, 'name' => 'admin 3' , 'type' => 'admin'],
    ['id' => 4, 'name' => 'admin 4' , 'type' => 'admin'],
    ['id' => 5, 'name' => 'user 1'  , 'type' => 'user' ],
    ['id' => 6, 'name' => 'user 2'  , 'type' => 'user' ],
    ['id' => 7, 'name' => 'user 3'  , 'type' => 'user' ],
]);

```

### Methods


#### #merge

```php
$collect->merge([
     ['id' => 8, 'name' => 'user 4', 'type' => 'user'],
     ['id' => 9, 'name' => 'user 5', 'type' => 'user'],
]);
```

#### #add

```php
$collect->add(['id' => 10, 'name' => 'user 6', 'type' => 'user']);
```

#### #count

```php
$collect->count();
```

#### #where

```php
$collect->where('type','user');
```

#### #like

```php
$collect->like('type','user');
# can like by array
$collect->like('type',['user','admin']);
```

#### #whereIn

```php
$collect->whereIn('id',[1,2,3,4]);
```

#### #whereNotIn

```php
$collect->whereNotIn('id',[5,3,7]);
```

#### #orderBy

```php
$collect->orderBy('id','desc');
```

#### #first

```php
$collect->first();
```


#### #all

```php
$collect->all();
```

#### #toArray

```php
$collect->toArray();
```
#### #toObject

```php
$collect->toObject();
```
## Copyright and License

The eslam-dev/collection library is copyright © [Eslam El Sherif](https://eslamelsherif.com)
and licensed for use under the terms of the MIT License (MIT).
