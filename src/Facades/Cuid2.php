<?php

declare(strict_types=1);

namespace Shikachuu\LaravelCuid2\Facades;

use Visus\Cuid2\Cuid2 as Cuid2Base;

final class Cuid2
{
    private const CUID2_REGEX = '^[0-9a-z]+$';

    public static function generate(): string
    {
        return (new Cuid2Base(config('cuid2.max-length')))->toString();
    }

    public static function validate(string $value): bool
    {
        $idLength = strlen($value);

        if ($idLength < 2 || $idLength > config('cuid2.max-length')) {
            return false;
        }

        return (bool)preg_match('/' . self::CUID2_REGEX . '/', $value);
    }
}
