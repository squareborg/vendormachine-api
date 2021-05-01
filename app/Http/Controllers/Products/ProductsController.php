<?php

namespace App\Http\Controllers\Products;

use App\Exceptions\Vendor\ManageProductsPermissionDeniedException;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\ProductTransformer;
use App\Models\Products\Product;
use App\DTO\Products\ProductData;
use App\Actions\Products\UpdateProductAction;
use App\Actions\Products\CreateProductAction;

class ProductsController extends Controller
{

    /**
     * List.
     *
     * @param Request $request
     * @return \Spatie\Fractal\Fractal
     */
    public function index(Request $request)
    {

        $query = Product::query();

        if ($request->has('s')) {
            $query->where('name', 'like', "%{$request->get('s')}%");
        }
        if(! $request->user()->hasRole('admin')) {
            $query->where('vendor_id', '=', $request->user()->vendor->id);
        }

        $paginator = $query->paginate();

        return fractal()
            ->collection($paginator->items(), new ProductTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator));

    }

    public function show(Product $product)
    {
        return fractal()->item($product, new ProductTransformer)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateProductAction $createProductAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CreateProductAction $createProductAction)
    {
        $payload = [
            'user_id' => $request->user()->id,
        ];
        try {
            $product = $createProductAction($request->merge($payload)->all());
        } catch (ManageProductsPermissionDeniedException $exception) {
            return response()->json(['message' => 'Permission denied'], Response::HTTP_FORBIDDEN);
        }
        return fractal()->item($product, new ProductTransformer())->respond(Response::HTTP_CREATED);
    }

     /**
     * List.
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, UpdateProductAction $updateProductAction)
    {
        return fractal()->item($updateProductAction(ProductData::fromRequest($request), $product))
            ->transformWith(new ProductTransformer)->respond();
    }

}
