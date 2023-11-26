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

    it('throws error on too short key length', fn() => Cuid2::generate(2))
        ->throws(OutOfRangeException::class);

    it('throws error on too long key length', fn() => Cuid2::generate(34))
        ->throws(OutOfRangeException::class);

    it('generates with the correct keyLength', function () {
        expect(Cuid2::generate(4))->toHaveLength(4);
        expect(Cuid2::generate())->toHaveLength(24);
    });

    it('validates correctly', function () {
        expect(Cuid2::validate("asd"))->toBeFalse();
        expect(Cuid2::validate("a!sd"))->toBeFalse();
        expect(Cuid2::validate("asAd"))->toBeFalse();
        expect(Cuid2::validate("asdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"))->toBeFalse();
        expect(Cuid2::validate("asdf12"))->toBeTrue();
        expect(Cuid2::validate(Cuid2::generate()))->toBeTrue();
    });
});
