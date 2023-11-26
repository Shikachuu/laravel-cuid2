<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;

use function Orchestra\Testbench\artisan;

describe('migrations', function (): void {
    it('runs successfully', function (): void {
        artisan($this, 'migrate');
        expect(Schema::hasColumn('flights', 'cuid'))->toBeTrue();
        expect(Schema::getColumnType('flights', 'cuid'))->toBe('string');
        $this->beforeApplicationDestroyed(
            fn () => artisan($this, 'migrate:rollback'),
        );
    });
});
