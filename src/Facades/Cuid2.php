<?php

declare(strict_types=1);

namespace Shikachuu\LaravelCuid2\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method string generate() Generates a new Cuid2 with the length defined in the config file (default: 24)
 * @method bool validate(string $string) Checks if the given string is a valid Cuid2
 */

class Cuid2 extends Facade
{
    protected static $cached = true;
    protected static function getFacadeAccessor(): string
    {
        return \Shikachuu\LaravelCuid2\Cuid2::class;
    }
}
