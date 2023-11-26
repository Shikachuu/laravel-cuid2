<?php

declare(strict_types=1);

namespace Shikachuu\LaravelCuid2;

use OutOfRangeException;
use Visus\Cuid2\Cuid2 as Cuid2Base;

class Cuid2
{
    private const CUID2_REGEX = '^[0-9a-z]+$';

    protected function validateKeyLength(int $keyLength): bool
    {
        if ($keyLength < 4 || $keyLength > 32) {
            throw new OutOfRangeException('cuid2.max-length: cannot be less than 4 or greater than 32');
        }

        return true;
    }

    public function generate(?int $keyLength = null): string
    {
        $actualKeyLength = $keyLength ?? config('cuid2.max-length');
        $this->validateKeyLength($actualKeyLength);

        return (new Cuid2Base($actualKeyLength))->toString();
    }

    public function validate(string $value): bool
    {
        $idLength = strlen($value);

        try {
            $this->validateKeyLength($idLength);
        } catch (OutOfRangeException) {
            return false;
        }

        return (bool)preg_match('/' . self::CUID2_REGEX . '/', $value);
    }
}
