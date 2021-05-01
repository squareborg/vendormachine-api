<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTO\UserData;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use App\Actions\Users\CreateUserAction;
use App\Actions\Users\SuspendUserAction;
use App\Actions\Users\UnsuspendUserAction;
use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Http\Requests\Users\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('s')) {
            $query->where('name', 'like', "%{$request->get('s')}%")
                ->orWhere('email', 'like', "%{$request->get('s')}%");
        }

        $paginator = $query->latest()->paginate(self::PAGINATION_LIMIT);

        return fractal()->collection($paginator->items(), new UserTransformer())
            ->parseIncludes(['roles'])
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateUserAction $createUserAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CreateUserAction $createUserAction)
    {
        return fractal()
            ->item($createUserAction(UserData::fromRequest($request)), new UserTransformer())->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return fractal()->item($user, new UserTransformer())
            ->parseIncludes(['roles', 'sites'])->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @param UpdateUserAction $updateUserAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, User $user, UpdateUserAction $updateUserAction)
    {
        if (! $request->has('email')) {
            $request->request->add(['email' => $user->email]);
        }
        $user = $updateUserAction($user, UserData::fromRequest($request));
        return fractal()->item($user, new UserTransformer())->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param DeleteUserAction $deleteUserAction
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, DeleteUserAction $deleteUserAction)
    {
        $deleteUserAction($user);
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Suspend the user.
     *
     * @param User $user
     * @param SuspendUserAction $suspendUserAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function suspend(User $user, SuspendUserAction $suspendUserAction)
    {
        $user = $suspendUserAction($user);
        return fractal()->item($user, new UserTransformer())->respond();
    }

    /**
     * Unsuspend the user
     *
     * @param User $user
     * @param UnsuspendUserAction $unsuspendUserAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsuspend(User $user, UnsuspendUserAction $unsuspendUserAction)
    {
        $user = $unsuspendUserAction($user);
        return fractal()->item($user, new UserTransformer())->respond();
    }
}
