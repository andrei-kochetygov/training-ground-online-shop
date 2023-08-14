<?php

namespace App\Models\Traits;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

use App\Pagination\SimpleJsonPaginator;

trait SimpleJsonPaginateTrait {
    public function scopeSimpleJsonPaginate(Builder $builder, $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $total = $builder->toBase()->getCountForPagination();

        $perPage = ($perPage instanceof Closure
            ? $perPage($total)
            : $perPage
        ) ?: $builder->model->getPerPage();

        $results = $total
            ? $builder->forPage($page, $perPage)->get($columns)
            : $builder->model->newCollection();

        return $this->simpleJsonPaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    protected function simpleJsonPaginator($items, $perPage, $currentPage, $options)
    {
        return new SimpleJsonPaginator($items, $perPage, $currentPage, $options);
    }
}
