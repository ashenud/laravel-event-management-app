<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait CanLoadRelationships
{
    public function loadRelationships(
        Model|EloquentBuilder|QueryBuilder|HasMany $builder,
        ?array $relations = null
    ): Model|EloquentBuilder|QueryBuilder|HasMany
    {
        $relations = $relations ?? $this->relations ?? [];

        foreach ($relations as $relation) {
            $builder->when(
                $this->shouldIncludeRelations($relation),
                fn() => $builder instanceof Model ? $builder->load($relation) : $builder->with($relation)
            );
        }

        return $builder;
    }

    private function shouldIncludeRelations(string $relation): bool
    {
        $includes = request()->query('include');

        if($includes === null) {
            return false;
        }

        $relations = array_map(
            fn($relation) => trim($relation),
            explode(',', $includes)
        );

        return in_array($relation, $relations);
    }
}
