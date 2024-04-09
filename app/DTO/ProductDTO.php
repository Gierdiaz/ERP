<?php

namespace App\DTO;

class ProductDTO
{
  public function __construct(
    public string $name,
    public string $description,
    public float $price,
    public int $amount_available = 0
  ){}
}