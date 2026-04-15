<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

final class GetCollectionUseCase
{
    public function handle(array $query): AnonymousResourceCollection
    {
        $result = User::query()
            ->when(! empty($query['start_date']) && ! empty($query['end_date']), function (Builder $q) use ($query) {
                return $q->whereBetween(DB::raw('date(created_at)'), [$query['start_date'], $query['end_date']]);
            })
            ->when(! empty($query['search']), function (Builder $q) use ($query) {
                return $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('prenoms', 'like', '%'.$query['search'].'%')
                        ->orWhere('nom', 'like', '%'.$query['search'].'%')
                        ->orWhere('email', 'like', '%'.$query['search'].'%');
                });
            });

        if (! empty($query['sort_by'])) {
            $result->orderBy($query['sort_by'], $query['sort_order'] ?? 'desc');
        } else {
            $result->orderBy('created_at', 'desc');
        }

        if (! empty($query['per_page'])) {
            $data = $result->paginate($query['per_page']);
        } else {
            $data = $result->get();
        }

        return UserResource::collection($data);
    }
}
