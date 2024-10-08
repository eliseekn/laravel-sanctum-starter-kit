<?php

declare(strict_types=1);

namespace App\Http\UseCases\v1\User;

use App\Http\Resources\v1\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class GetCollectionUseCase
{
    public function handle(array $query): UserCollection
    {
        $users = User::query()
            ->when(! empty($query['search']), function ($q) use ($query) {
                return $q->where('name', 'like', '%'.$query['search'].'%')
                    ->orWhere('email', 'like', '%'.$query['search'].'%');
            })
            ->when(! empty($query['startDate']) && ! empty($query['endDate']), function ($q) use ($query) {
                return $q->whereBetween(DB::raw('date(created_at)'), [$query['startDate'], $query['endDate']]);
            })
            ->orderBy('created_at', 'desc');

        if (! empty($query['limit'])) {
            return new UserCollection(
                $users->paginate($query['limit'], ['*'], 'page', $query['page'])
            );
        }

        return new UserCollection($users->get());
    }
}
