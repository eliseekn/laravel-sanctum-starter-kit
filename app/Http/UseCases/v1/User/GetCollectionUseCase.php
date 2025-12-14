<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

final class GetCollectionUseCase
{
    public function handle(array $query): AnonymousResourceCollection
    {
        $query = User::query()
            ->when(! empty($query['startDate']) && ! empty($query['endDate']), function (Builder $q) use ($query) {
                return $q->whereBetween(DB::raw('date(created_at)'), [$query['startDate'], $query['endDate']]);
            })
            ->when(! empty($query['search']), function (Builder $q) use ($query) {
                return $q->where('prenoms', 'like', '%'.$query['search'].'%')
                    ->orWhere('name', 'like', '%'.$query['search'].'%')
                    ->orWhere('email', 'like', '%'.$query['search'].'%');
            })
            ->orderBy('created_at', 'desc');

        if (! empty($query['perPage'])) {
            $users = $query->paginate($query['perPage']);
        } else {
            $users = $query->get();
        }

        return UserResource::collection($users);
    }
}
