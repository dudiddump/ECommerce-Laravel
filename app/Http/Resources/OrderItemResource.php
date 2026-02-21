<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
        ];
    }
}
