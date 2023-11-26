<?php

declare(strict_types=1);

namespace Shikachuu\LaravelCuid2;

use OutOfRangeException;
use Visus\Cuid2\Cuid2 as Cuid2Base;

class Cuid2
{
    private const CUID2_REGEX = '^[0-9a-z]+$';
    private int $keyLength;

    protected function getKeyLength()
    {
        if (isset($this->keyLength) === false) {
            $this->keyLength = config('cuid2.max-length');
        }

        if ($this->keyLength < 4 || $this->keyLength > 32) {
            throw new OutOfRangeException("cuid2.max-length: cannot be less than 4 or greater than 32");
        }

        return $this->keyLength;
    }

    public function generate(): string
    {
        return (new Cuid2Base($this->getKeyLength()))->toString();
    }

    public function validate(string $value): bool
    {
        $idLength = strlen($value);

        if ($idLength < 4 || $idLength > $this->getKeyLength()) {
            return false;
        }

        return (bool)preg_match('/' . self::CUID2_REGEX . '/', $value);
    }
}
