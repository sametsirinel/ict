<?php

namespace App\Libraries;

use App\Models\OrderProducts;
use App\Models\Orders;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Report
{
    public function getProductCountFromOrderStatus()
    {
        return DB::table("order_products")
            ->selectRaw("count(order_products.id) as product_count, order_statuses.id as order_status_id, order_statuses.status")
            ->leftJoin("orders", "orders.id", "=", "order_products.order_id")
            ->join("order_statuses","order_statuses.id","=","orders.status_id")
            ->groupBy("order_statuses.id")
            ->get()
            ->toArray();
    }


    public function getMostOrderedProductAndNotInStockOfYear()
    {
        $query = DB::table("order_products")
        ->selectRaw("count(products.id) as product_count ,order_products.product_id as product_id")
        ->leftJoin("products", "products.id", "=", "order_products.product_id")
        ->join("orders", "orders.id", "=", "order_products.order_id")
        ->whereRaw("products.stock_status = false")
        ->where("orders.order_date", ">", now()->subYear())
        ->groupBy("order_products.product_id")
        ->orderBy("product_count", "desc")
        ->limit(5)
        ->toRawSql();

        return DB::table('order_products')
            ->join("orders","orders.id", "=", "order_products.order_id")
            ->where("orders.order_date", ">", \now()->subMonth())
            ->whereIn("order_products.product_id", function($q) use ($query){
                 $q->select(["sub.product_id"])
                    ->fromSub($query, "sub");
             })
            ->get();
    }
}