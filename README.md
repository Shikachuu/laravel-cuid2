# Laravel CUID2

The missing [CUID2](https://github.com/paralleldrive/cuid2#why) implementation for your Laravel apps.

Secure, collision-resistant ids, basically the next generation UUIDs.

## Installation

You can install the package via `composer`:

```shell
composer require shikachuu/laravel-cuid2
```

You can publish the configuration file with:

```shell
php artisan vendor:publish --provider="Shikachuu\LaravelCuid2\Cuid2ServiceProvider"
```

The configuration file will be published in `config/cuid2.php`, in this file you can change the default `key-length`
which is set to `24` by default.

## Usage

### Basic usage via Facade or a helper function

This is the simplest way to create a new CUID2 in your Laravel app.

You can use the provided facades and a helper function:

```php
$id = cuid2();
// or provide an argument with the key size
$id = cuid2(30);
// or call the facade directly
$idFromTheFacade = \Shikachuu\LaravelCuid2\Facades\Cuid2::generate(30);
```

Now let's validate our example above:

```php
\Shikachuu\LaravelCuid2\Facades\Cuid2::validate($id);
```

### Validation

You can use the provided `cuid2` validation rule in the
default [Laravel's Validator](https://laravel.com/docs/10.x/validation#validation-quickstart):

```php
Validator::validate(['cuid' => 'qo08kg4ogogcc4sowwskkwko'], ['cuid' => 'cuid2']);
```

### Migrations

You can use `cuid2` and `foreignCuid2` as field types in your migrations:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table): void {
            $table->cuid2()->primary(); // generates a `cuid2` filed to use it as the primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
```

By default, these rules will create a filed `cuid2`, but you have the ability to customize this behaviour by defining
the column name explicitly:

```php
$table->cuid2('myFieldName');
```

### Models

Just like UUIDs, you can also use CUID2 in your models to automatically generate and validate IDs in your queries:

```php
<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Shikachuu\LaravelCuid2\Eloquent\Concerns\HasCuid2;

class Orders extends Model
{
    use HasCuid2;
    protected $primaryKey = 'cuid2';
}
```

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

## Contributing

Here are a few guidelines for contributing:

* If you would like to contribute to the codebase then please raise an issue to propose the change or feature.
* Do not mix feature changes or fixes with refactoring - it makes the code harder to review and means there is more for
  the maintainers (with limited time) to test.
* Don't raise PRs for typos, these aren't necessary - just raise an Issue.
* Please always provide a summary of what you changed, how you did it and how it can be tested.
* Most of the time we like to keep one commit per PR or if you have more you should have a perfect reason for it.
* All commits must have a `Signed-off-by:` line in accordance with the Developer Certificate of Origin.
* All changes must be linted via `composer lint` and must pass both old and new tests.

To test your changes use the included `composer test` command, please always cover your changes with appropriate test
cases, prefer [table tests](https://pestphp.com/docs/datasets) when possible.

Example files are always a welcome addition in the workbench folder. Feel free to provide example use cases for your
fix/feature.

All tests and code in this repo are should be able to run in a raw `php:8.2-cli-alpine` container using on OCI runtime.
(In my case: `podman run --rm -it -v $PWD:/app:Z -w /app php:8.2-cli-alpine ash`) this might be replaced in the future,
with devcontainers or a [bake file](https://docs.docker.com/build/bake/reference/).