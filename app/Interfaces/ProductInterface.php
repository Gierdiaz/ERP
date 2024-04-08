<?php

namespace App\Interfaces;

use App\DTO\ProductDTO;

interface ProductInterface
{
  public function getAll();

  public function create(ProductDTO $productDTO);
}
