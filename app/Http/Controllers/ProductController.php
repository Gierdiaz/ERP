<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponse;
use App\DTO\ProductDTO;
use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function show(Product $product)
    {
        //
    }

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

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->getById($id);
            $this->productRepository->delete($product);
            
            DB::commit();
            Log::channel('product')->info('Product deleted successfully', ['id' => $id]);

            return ApiResponse::sendResponse([] , __('Product deleted successfully'));
        }
        catch(\Exception $e) {
            DB::rollBack();
            return ApiResponse::rollback($e, 
             __('Failed to delete Product: '. $e->getMessage())
            );
        }
    }
}
