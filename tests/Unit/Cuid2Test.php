<?php

declare(strict_types=1);


use Shikachuu\LaravelCuid2\Facades\Cuid2;

describe('Cuid2 logic', function (): void {
    it('registers the helper function', function (): void {
        expect(function_exists('cuid2'))->toBeTrue();

        $mockCuid2 = Cuid2::spy();
        $mockReturn = 'qwe';

        $mockCuid2->expects('generate')->andReturn($mockReturn);
        expect(\cuid2())->toBe($mockReturn);
    });

    it('throws error on too short/long key length', fn(int $keyLength) => Cuid2::generate($keyLength))
        ->throws(OutOfRangeException::class)
        ->with([
            1,
            2,
            3,
            33,
            120,
        ]);

    it('generates with the correct key length', function (?int $keyLength) {
        expect(Cuid2::generate($keyLength))->toHaveLength($keyLength ?? 24);
    })->with([
        null,
        4,
        12,
        30,
    ]);

    it('validates correctly', function (string $actual, bool $expected) {
        expect(Cuid2::validate($actual))->toBeBool()->toBe($expected);
    })->with([
        ['asd', false],
        ['asd!', false],
        ['asdA', false],
        ['asdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', false],
        ['asd123', true],
        ['qo08kg4ogogcc4sowwskkwko', true],
    ]);
});
