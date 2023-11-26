<?php

declare(strict_types=1);

namespace Shikachuu\LaravelCuid2;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Shikachuu\LaravelCuid2\Facades\Cuid2 as Cuid2Facade;

class Cuid2ServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Validator::extend(
            'cuid2',
            fn ($attribute, $value, $parameters, $validator) => Cuid2Facade::validate($value),
        );

        Blueprint::macro(
            'cuid2',
            function (string $column = 'cuid2', ?int $length = null): ColumnDefinition {
                if ($length === null) {
                    $length = config('cuid2.max-length');
                }
                /** @var \Illuminate\Database\Schema\Blueprint $this */
                return $this->char($column, $length);
            },
        );

        Blueprint::macro(
            'foreignCuid2',
            function (string $column = 'cuid2', ?int $length = null): ColumnDefinition {
                /** @var \Illuminate\Database\Schema\Blueprint $this */
                return $this->addColumnDefinition(
                    new ForeignIdColumnDefinition($this, [
                        'type' => 'char',
                        'name' => $column,
                        'length' => $length,
                    ]),
                );
            },
        );

        $this->publishes([__DIR__ . '/../config/cuid2.php' => config_path('cuid2.php')]);

        $this->mergeConfigFrom(__DIR__ . '/../config/cuid2.php', 'cuid2');
    }
}
