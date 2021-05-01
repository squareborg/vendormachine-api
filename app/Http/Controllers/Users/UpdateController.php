<?php

namespace App\Http\Controllers\Users;

use App\DTO\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateRequest;
use App\Transformers\UserTransformer;
use App\Actions\Users\UpdateUserAction;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, UpdateUserAction $updateUserAction)
    {
        try {
            $user = $updateUserAction($request->user(), UserData::fromRequest($request));
            return fractal()->item($user, new UserTransformer());
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
