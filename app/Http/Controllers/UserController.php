<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\User as UserResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    /**
     * Store a newly created user in database.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User(
            [
                'name' => $request['data.attributes.name'],
                'email' => $request['data.attributes.email'],
                'permission' => $request['data.attributes.permission'],
            ]
        );

        $user->save();

        return response()->json(new UserResource($user), 201);
    }

}
