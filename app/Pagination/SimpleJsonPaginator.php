<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class SimpleJsonPaginator extends LengthAwarePaginator 
{
    public function toArray()
    {
        return [
            'pagination' => [
                'pages' => [
                    'current' => $this->currentPage(),
                    'last' => $this->lastPage(),
                ],
                'items' => [
                    'per_page' => $this->perPage(),
                    'from' => $this->firstItem(),
                    'to' => $this->lastItem(),
                    'total' => $this->total(),
                ],
            ],
            'items' => $this->items->toArray(),
        ];
    }
}
