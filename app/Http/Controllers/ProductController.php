<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function get(Products $product)
    {
        try {
            $data = new ProductResource($product);

            return $this->success([
                'product' => $data->resolve(),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {      
            return $this->error();
        }
    }

    public function store(ProductRequest $request)
    {   
        try {
            return $product = Products::create([
                ...$request->validated(),
                "stock_status" => !!$request->stock_status
            ]);

            $data = new ProductResource($product);

            return $this->success([
                'product' => $data->resolve(),
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error();
        }
    }


    public function update(ProductRequest $request,int $product_id)
    {
        $product = Products::withTrashed()->find($product_id);

        try {

            if($product->deleted_at){
                return $this->error(__("Silinmiş Ürün Güncellenemez"));
            }

            $product->update($request->validated());

            $data = new ProductResource($product);

            return $this->success([
                'product' => $data->resolve(),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {            
            return $this->error();
        }
    }


    public function destroy(Products $product)
    {
        try {
            $product->delete();

            return $this->success([
                'message' => __("Content Successfully Deleted")
            ], Response::HTTP_OK);
        } catch (\Exception $e) {      
            return $this->error();
        }
    }
}
