<?php

namespace App\Repositories;
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
}