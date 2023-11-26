<?php

declare(strict_types=1);

use Shikachuu\LaravelCuid2\Facades\Cuid2;

if (function_exists('cuid2') === false) {
    function cuid2(?int $keyLength = null): string
    {
        return Cuid2::generate($keyLength);
    }
}
