<?php

namespace App\Repositories;

use App\DTO\ProductDTO;
use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface
{
    protected $model;
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAll()
    {
        return $this->model->orderBy('created_at', 'desc')->paginate();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(ProductDTO $productDTO)
    {
        return $this->model->create((array)$productDTO);
    }

    public function update(Product $product, ProductDTO $productDTO)
    {
        $product->update([
            'name'             => $productDTO->name,
            'description'      => $productDTO->description,
            'amount_available' => $productDTO->amount_available,
            'price'            => $productDTO->price,
        ]);

        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }

}
