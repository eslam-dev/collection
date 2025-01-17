<h1 align="center">eslam-dev/collection</h1>

<p align="center">
    <strong>A PHP library for representing and manipulating collections.</strong>
</p>

## About


`eslam-dev/collection` is a powerful PHP library for managing and manipulating collections. It provides an elegant API for working with arrays and objects, featuring advanced filtering, mapping, grouping, and transformation methods.

## Installation
------------

Install the package using [Composer](https://getcomposer.org):

    composer require eslam-dev/collection

## Usage
-----

### Generic Collection

The `collect` helper creates a new instance of the `EslamDev\Collection` class for the given array:
```php
$collect = collect([
    ['id' => 1, 'name' => 'admin', 'type' => 'admin'],
    ['id' => 2, 'name' => 'admin 2', 'type' => 'admin'],
    ['id' => 3, 'name' => 'admin 3', 'type' => 'admin'],
    ['id' => 4, 'name' => 'admin 4', 'type' => 'admin'],
    ['id' => 5, 'name' => 'user 1', 'type' => 'user'],
]);
```
Methods and Examples
--------------------

### Methods


#### #merge


Merge additional items into the collection:
```php
$collect->merge([
    ['id' => 8, 'name' => 'user 4', 'type' => 'user'],
    ['id' => 9, 'name' => 'user 5', 'type' => 'user'],
]);
```
### #add

Add a single item to the collection:
```php
$collect->add(['id' => 10, 'name' => 'user 6', 'type' => 'user']);
```
### #count

Count the total number of items in the collection:
```php
$collect->count();
```
### #where

Filter the collection by a specific key-value pair:
```php
$collect->where('type', 'user');
```
### #like

Filter items using a pattern. You can use `%` as a wildcard:
```php
$collect->like('type', 'user');
// Supports array patterns
$collect->like('type', ['user', 'admin']);
```
### #whereIn

Filter items where the key matches any value in an array:
```php
$collect->whereIn('id', [1, 2, 3, 4]);
```
### #whereNotIn

Filter items where the key does not match any value in an array:
```php
$collect->whereNotIn('id', [5, 3, 7]);
```
### #orderBy

Sort the collection by a specific key and direction:
```php
$collect->orderBy('id', 'desc');
```
### #first

Get the first item in the collection:
```php
$collect->first();
```
### #toArray

Convert the collection into an array:
```php
$collect->toArray();
```
### #toObject

Convert the collection into an object:
```php
$collect->toObject();
```
License
-------

The `eslam-dev/collection` library is licensed under the MIT License. See the `LICENSE` file for details.

Author
------

This library is developed and maintained by [Eslam El Sherif](https://eslamelsherif.com).