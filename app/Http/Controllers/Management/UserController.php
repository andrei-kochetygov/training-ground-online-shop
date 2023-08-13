<?php

namespace App\Http\Controllers\Management;

use App\Docs;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\UserStoreRequest;
use App\Http\Requests\Management\UserUpdateRequest;

#[Docs\FeatureTag('Users (Management)')]
class UserController extends Controller
{
    // #[
    //     Docs\Http\Methods\Get(
    //         path: '/api/manage/users',
    //         secured: true,
    //     ),
    //     Docs\Http\Responses\Ok,
    // ]
    public function index()
    {
        return User::paginate(20);
    }

    // #[
    //     Docs\Http\Methods\Post(
    //         path: '/api/manage/users',
    //         secured: true,
    //     ),
    //     Docs\Http\Responses\Created,
    // ]
    public function store(UserStoreRequest $request)
    {
        $user = new User();

        $user->fill($request->validated());

        $user->save();

        return $user;
    }

    // #[
    //     Docs\Http\Methods\Get(
    //         path: '/api/manage/users/{id}',
    //         secured: true,
    //     ),
    //     Docs\Http\Requests\Parameter(
    //         name: 'id',
    //         in: 'path',
    //         required: true,
    //         example: 1,
    //     ),
    //     Docs\Http\Responses\Ok,
    // ]
    public function show(User $user)
    {
        return $user;
    }

    // #[
    //     Docs\Http\Methods\Put(
    //         path: '/api/manage/users/{id}',
    //         secured: true,
    //     ),
    //     Docs\Http\Requests\Parameter(
    //         name: 'id',
    //         in: 'path',
    //         required: true,
    //         example: 1,
    //     ),
    //     Docs\Http\Responses\Ok,
    // ]
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->fill($request->validated());

        $user->save();

        return $user;
    }

    // #[
    //     Docs\Http\Methods\Delete(
    //         path: '/api/manage/users/{id}',
    //         secured: true,
    //     ),
    //     Docs\Http\Requests\Parameter(
    //         name: 'id',
    //         in: 'path',
    //         required: true,
    //         example: 1,
    //     ),
    //     Docs\Http\Responses\Ok,
    // ]
    public function destroy(User $user)
    {
        $user->delete();

        return $user;
    }

    // #[
    //     Docs\Http\Methods\Get(
    //         path: '/api/manage/users/{id}/orders',
    //         secured: true,
    //     ),
    //     Docs\Http\Requests\Parameter(
    //         name: 'id',
    //         in: 'path',
    //         required: true,
    //         example: 1,
    //     ),
    //     Docs\Http\Responses\Ok,
    // ]
    public function showOrders(User $user)
    {
        return $user->orders;
    }
}
