<?php

namespace App\Interfaces;

use App\DTO\ProductDTO;
use App\Models\Product;

interface ProductInterface
{
    public function getAll();

    public function getById($id);

    public function create(ProductDTO $productDTO);

    public function update(Product $product, ProductDTO $productDTO);

    public function delete(Product $product);
}
