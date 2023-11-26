<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Shikachuu\LaravelCuid2\Eloquent\Concerns\HasCuid2;
use Shikachuu\LaravelCuid2\Facades\Cuid2;

describe('cuid2 ID trait', function (): void {
    it('facade called correctly', function (): void {
        $mockCuid = Cuid2::spy();
        $fakeId = 'asd';

        $mockCuid->expects('generate')->andReturn($fakeId);

        $model = new class () extends Model {
            use HasCuid2;
        };
        expect($model->newUniqueId())->toBe($fakeId);

        $mockCuid->expects('validate')->andReturn(false);
        expect($model->resolveRouteBindingQuery($model, 'a', 'id'));
    })->throws(ModelNotFoundException::class);

    it('validates every trait method is extended correctly', function (): void {
        $model = new class () extends Model {
            use HasCuid2;

            protected $primaryKey = 'cuid';
        };

        $mockCuid = Cuid2::spy();
        $fakeId = 'asd';
        $mockCuid->shouldReceive('generate')->andReturn($fakeId);

        expect($model->newUniqueId())->toBe($fakeId);
        expect($model->getKeyType())->toBe('string');
        expect($model->getIncrementing())->toBe(false);
        expect($model->getKeyName())->toBe('cuid');
        expect($model->uniqueIds())->toMatchArray(['cuid']);
    });
});
