<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // FIXME
        /* İstenilen dönüş değeri;
            Siparişe ait bilgiler, durum bilgisi ile birlikte order altında,
            Müşteri isim/soyisim customer altında
            Siparişteki ürünlerin isimleri ve ID'leri products altında. Bir ürün siparişten sonra ürün tablosunda pasife alınmış olsa dahi bu endpointte listelenmelidir
         */

        return [
            'order' => [],
            'customer' => [],
            'products' => []
        ];
    }
}
