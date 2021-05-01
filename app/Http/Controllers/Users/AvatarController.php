<?php

namespace App\Http\Controllers\Users;

use App\Actions\Users\UpdateAvatarAction;
use App\DTO\AvatarData;
use App\Http\Requests\Users\AvatarRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class AvatarController extends Controller
{
    public function __invoke(AvatarRequest $request, UpdateAvatarAction $updateAvatarAction)
    {
        try {
            $user = $updateAvatarAction($request->user(), AvatarData::fromRequest($request));
            return fractal()->item($user, new UserTransformer());
        } catch (Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
