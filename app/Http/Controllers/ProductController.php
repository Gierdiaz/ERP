<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
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
