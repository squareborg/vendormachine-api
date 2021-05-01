<?php

namespace App\Http\Controllers\Vendors;

use App\DTO\VendorData;
use App\Http\Controllers\Controller;
use App\Transformers\VendorTransformer;
use App\Actions\vendors\CreateVendorAction;
use App\Actions\vendors\UpdateVendorAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Vendor;

class VendorsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/vendors",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */

    /**
     * List.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Vendor::query();

        if ($request->has('s')) {
            $query->where('name', 'like', "%{$request->get('s')}%");
        }
        $paginator = $query->paginate();
        return fractal()
            ->collection($paginator->items(), new VendorTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond();

    }

    /**
     * List.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Vendor $vendor)
    {
        return fractal()->item($vendor, new VendorTransformer())->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateVendorAction $createVendorAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CreateVendorAction $createVendorAction)
    {
        $vendor = $createVendorAction(VendorData::fromRequest($request));
        return fractal()->item($vendor, new VendorTransformer())->respond(Response::HTTP_CREATED);
    }


    /**
     * @OA\Put(
     *     path="/vendors/{vendor}",
     *     description="Updates a vendor",
     *     @OA\Response(response="", description="")
     * )
     */

    /**
     * Update a resource in storage.ass
     *
     * @param Request $request
     * @param UpdateVendorAction $updateVendorAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Vendor $vendor, UpdateVendorAction $updateVendorAction)
    {
            $vendor = $updateVendorAction(VendorData::fromRequest($request), $vendor);
            return fractal()->item($vendor, new VendorTransformer())->respond();
    }

}
