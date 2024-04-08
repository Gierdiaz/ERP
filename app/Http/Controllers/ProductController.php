<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponse;
use App\DTO\ProductDTO;
use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    

    public function index()
    {
        try {
            $products = $this->productRepository->getAll();
            return ApiResponse::sendResponse(
                ProductResource::collection($products),
                '',
                200
            );
        }
        catch(\Exception $e) {
            return ApiResponse::throw($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        try {
            $validated = $request->validated();
            $productDTO = new ProductDTO(
                $validated['name'],
                $validated['description'],
                $validated['price'],
                $validated['amount_available']
            );

            $product = $this->productRepository->create($productDTO);

            Log::channel('product')->info('product created successfully', ['$product_id' => $product->id]);

            return ApiResponse::sendResponse(
                new ProductResource($product),
                'Product created successfully',
                201
            );
        }
        catch(\Exception $e) {
            return ApiResponse::throw($e, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
