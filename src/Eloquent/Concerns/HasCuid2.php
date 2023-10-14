<?php

declare(strict_types=1);

namespace Shikachuu\LaravelCuid2\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasCuid2
{
    /**
     * Initialize the trait.
     *
     * @return void
     */
    public function initializeHasCuid2(): void
    {
        $this->usesUniqueIds = true;
    }

    /**
     * Get the columns that should receive a unique identifier.
     */
    public function uniqueIds(): array
    {
        return [$this->getKeyName()];
    }

    /**
     * Generate a new Cuid2 for the model.
     */
    public function newUniqueId(): string
    {
        return Cuid2::generate();
    }

    /**
     * Retrieve the model for a bound value.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function resolveRouteBindingQuery(Model|Relation $query, mixed $value, ?string $field = null): Relation
    {
        if (
            $field !== null
            && in_array($field, $this->uniqueIds(), true)
            && Cuid2::validate((string)$value) === false
        ) {
            throw (new ModelNotFoundException())->setModel(get_class($this), $value);
        }

        if (
            $field === null
            && in_array($this->getRouteKeyName(), $this->uniqueIds(), true)
            && Cuid2::validate((string)$value)
        ) {
            throw (new ModelNotFoundException())->setModel(get_class($this), $value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing(): bool
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return false;
        }

        return $this->incrementing;
    }
}
