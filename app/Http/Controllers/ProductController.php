<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Services\Product\ProductService;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * @param  ProductService  $product_service
     * @param  ProductIndexRequest  $request
     *
     * @return Response
     */
    public function index(ProductService $product_service, ProductIndexRequest $request): Response
    {
        return Inertia::render('Product/Index', [
            'products' => $product_service->getAllFromXmlPaginated($request->count ?? 3),
        ]);
    }
}
