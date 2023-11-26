<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Validator;
use Shikachuu\LaravelCuid2\Facades\Cuid2;

describe('service provider', function (): void {
    it('registers the blueprint macros', function (): void {
        expect(Blueprint::hasMacro('cuid2'))->toBeTrue('missing cuid2 macro');
        expect(Blueprint::hasMacro('foreignCuid2'))->toBeTrue('missing foreignCuid2 macro');
    });

    it('registers validation rule', function (): void {
        $mockCuid2 = Cuid2::spy();
        $mockCuid2->expects('validate')->andReturn(true);
        Validator::validate(['cuid' => 'adf555'], ['cuid' => 'cuid2']);
    });

    it('registers and publishes config', function (): void {
        expect(config('cuid2'))->toHaveKey('max-length');
    });
});
