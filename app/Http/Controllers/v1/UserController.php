<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\StoreRequest;
use App\Http\Requests\v1\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\UseCases\v1\User\DeleteUseCase;
use App\Http\UseCases\v1\User\GetCollectionUseCase;
use App\Http\UseCases\v1\User\StoreUseCase;
use App\Http\UseCases\v1\User\UpdateUseCase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group('Users')]
#[Authenticated()]
class UserController extends Controller
{
    #[QueryParam('page', 'int', 'Page number', example: 1)]
    #[QueryParam('per_page', 'int', 'Number of items per page', example: 15)]
    #[QueryParam('search', 'string', 'Search query (name, email)', example: 'john doe')]
    #[QueryParam('start_date', 'string', 'Filter by start date (created_at)', example: '2025-01-01')]
    #[QueryParam('end_date', 'string', 'Filter by end date (created_at)', example: '2025-12-31')]
    #[QueryParam('sort_by', 'string', 'Sort by field (name, email, created_at)', example: 'name')]
    #[QueryParam('sort_order', 'string', 'Sort order (asc, desc)', example: 'asc')]
    #[ResponseFromApiResource(UserResource::class, User::class, collection: true, paginate: 15)]
    public function index(Request $request, GetCollectionUseCase $useCase): AnonymousResourceCollection
    {
        return $useCase->handle($request->query());
    }

    #[ResponseFromApiResource(UserResource::class, User::class)]
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(StoreRequest $request, StoreUseCase $useCase): JsonResponse
    {
        return $useCase->handle($request->validated());
    }

    public function update(UpdateRequest $request, User $user, UpdateUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user, $request->validated());
    }

    public function destroy(Request $request, User $user, DeleteUseCase $useCase): JsonResponse
    {
        if ($request->user('sanctum')->cannot('delete', $user)) {
            abort(403);
        }

        return $useCase->handle($user);
    }
}
