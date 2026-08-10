<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class GetCollectionUseCase
{
    public function handle(array $query): LengthAwarePaginator|Collection
    {
        $result = User::query()
            ->when(! empty($query['start_date']) && ! empty($query['end_date']), function (Builder $q) use ($query) {
                return $q->whereBetween(DB::raw('date(created_at)'), [$query['start_date'], $query['end_date']]);
            })
            ->when(! empty($query['search']), function (Builder $q) use ($query) {
                return $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', '%'.$query['search'].'%')
                        ->orWhere('email', 'like', '%'.$query['search'].'%');
                });
            });

        if (! empty($query['sort_by'])) {
            $result->orderBy($query['sort_by'], $query['sort_order'] ?? 'desc');
        } else {
            $result->orderBy('created_at', 'desc');
        }

        return ! empty($query['per_page'])
            ? $result->paginate($query['per_page'])
            : $result->get();
    }
}
