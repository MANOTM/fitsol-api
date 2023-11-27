<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->UltraProduct->product_id,
            'name'=>$this->name,
            'genre'=>$this->genre,
            'brind'=>$this->brind,
            'mainImg'=>$this->mainImg,
            'description'=>$this->UltraProduct->description,
            'token'=>$this->token,
            'secondImg'=>$this->secondImg,
            'size'=>[['size38'=>$this->UltraProduct->size38],
            ['size39'=>$this->UltraProduct->size39],
            ['size40'=>$this->UltraProduct->size40],
            ['size41'=>$this->UltraProduct->size41],
            ['size42'=>$this->UltraProduct->size42],
            ['size43'=>$this->UltraProduct->size43]
        ],
            'price'=>$this->price,
            'discount'=>$this->discount,
            'stock'=>$this->stock,
            'secondImg'=>$this->UltraProduct->secondImg,
        ];
    }
}
