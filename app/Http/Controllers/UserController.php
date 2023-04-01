<?php

namespace App\Http\Controllers;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:' . PermissionsEnum::ViewUsers->value)->only([
            'index'
        ]);
        $this->middleware('role:' . RolesEnum::Admin->value)->except([
            'index'
        ]);
    }

    public function index(UserRequest $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $data = $request->validated();
        $users = User::query()->applyAllFilters($data);
        return self::getJsonResponse('Success', $users);
    }

    public function show(UserRequest $request, $userId): JsonResponse
    {
        $data = $request->validated();
        $data['where_id'] = $userId;
        $user = User::query()->loadRelations($data)->filter($data)->firstOrFail();
        $this->authorize('view', $user);
        return self::getJsonResponse('Success', $user);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        try {
            DB::beginTransaction();
            /** @var User $newUser */
            $newUser = User::query()->create($data);
            $newUser->syncRoles($data['role']);
            if (isset($data['permissions'])) {
                $newUser->syncPermissions($data['permissions']);
            }
            DB::commit();
            return self::getJsonResponse('success', $newUser);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(UserRequest $request, $userId): JsonResponse
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            /** @var User $user */
            $user = User::query()->findOrFail($userId);
            $this->authorize('update', $user);
            $user->update($data);
            if (isset($data['role'])) {
                $user->syncRoles($data['role']);
            }
            if (isset($data['permissions'])) {
                $user->syncPermissions($data['permissions']);
            }
            DB::commit();
            return self::getJsonResponse('success', $user);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy($userId): JsonResponse
    {
        $user = User::query()->findOrFail($userId);
        $this->authorize('delete', $user);
        $user->delete();
        return self::getJsonResponse('Success');
    }
}
