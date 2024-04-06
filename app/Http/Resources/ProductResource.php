<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $request->id,
      'name' => $request->name,
      'description' => $request->description,
      'price' => $request->price,
      'amount_available' => $request->amount_available,
    ];
  }
}