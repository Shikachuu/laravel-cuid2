<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shikachuu\LaravelCuid2\Facades\HasCuid2;

class Flight extends Model
{
    use HasCuid2;
    use HasFactory;
    use HasTimestamps;
}
