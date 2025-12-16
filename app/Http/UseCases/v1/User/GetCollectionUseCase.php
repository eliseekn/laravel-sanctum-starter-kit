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
            ->when(! empty($query['startDate']) && ! empty($query['endDate']), function (Builder $q) use ($query) {
                return $q->whereBetween(DB::raw('date(created_at)'), [$query['startDate'], $query['endDate']]);
            })
            ->when(! empty($query['search']), function (Builder $q) use ($query) {
                return $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('prenoms', 'like', '%'.$query['search'].'%')
                        ->orWhere('name', 'like', '%'.$query['search'].'%')
                        ->orWhere('email', 'like', '%'.$query['search'].'%');
                });
            })
            ->orderBy('created_at', 'desc');

        if (! empty($query['perPage'])) {
            $users = $result->paginate($query['perPage']);
        } else {
            $users = $result->get();
        }

        return UserResource::collection($users);
    }
}
