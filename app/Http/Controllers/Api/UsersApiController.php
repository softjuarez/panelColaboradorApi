<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersApiController extends BaseApiController
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Get query parameters for pagination and filtering
            $perPage = $request->get('per_page', 15);
            $perPage = min($perPage, 100); // Limit max per page to 100
            
            $search = $request->get('search');
            $sortBy = $request->get('sort_by', 'name');
            $sortOrder = $request->get('sort_order', 'asc');

            // Validate sort parameters
            $allowedSortFields = ['id', 'name', 'lastname', 'email', 'created_at'];
            if (!in_array($sortBy, $allowedSortFields)) {
                $sortBy = 'name';
            }

            if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
                $sortOrder = 'asc';
            }

            // Build query
            $query = User::query();

            // Apply search filter if provided
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Apply sorting
            $query->orderBy($sortBy, $sortOrder);

            // Get paginated results
            $users = $query->paginate($perPage);

            // Transform the data to exclude sensitive information
            $transformedUsers = $users->getCollection()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'created_at' => $user->created_at?->toISOString(),
                    'updated_at' => $user->updated_at?->toISOString(),
                    'roles' => $user->roles->map(function ($role) {
                        return [
                            'id' => $role->id,
                            'name' => $role->name ?? 'N/A',
                        ];
                    }),
                ];
            });

            // Replace the collection in the paginator
            $users->setCollection($transformedUsers);

            return $this->paginatedResponse($users, 'Users retrieved successfully');

        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve users: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = User::with('roles')->find($id);

            if (!$user) {
                return $this->notFoundResponse('User not found');
            }

            $transformedUser = [
                'id' => $user->id,
                'name' => $user->name,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'created_at' => $user->created_at?->toISOString(),
                'updated_at' => $user->updated_at?->toISOString(),
                'roles' => $user->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name ?? 'N/A',
                    ];
                }),
            ];

            return $this->successResponse($transformedUser, 'User retrieved successfully');

        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve user: ' . $e->getMessage());
        }
    }

    /**
     * Get the currently authenticated user.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return $this->unauthorizedResponse('User not authenticated');
            }

            $user->load('roles');

            $transformedUser = [
                'id' => $user->id,
                'name' => $user->name,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'created_at' => $user->created_at?->toISOString(),
                'updated_at' => $user->updated_at?->toISOString(),
                'roles' => $user->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name ?? 'N/A',
                    ];
                }),
            ];

            return $this->successResponse($transformedUser, 'Current user retrieved successfully');

        } catch (\Exception $e) {
            return $this->serverErrorResponse('Failed to retrieve current user: ' . $e->getMessage());
        }
    }
}
