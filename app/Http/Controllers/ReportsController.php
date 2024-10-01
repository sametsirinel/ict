<?php

namespace App\Http\Controllers;

use App\Libraries\Report;
use Illuminate\Http\JsonResponse;

class ReportsController extends Controller
{
    public function getProductCountFromOrderStatus(Report $report): JsonResponse
    {
        return $this->success([
            "product" => $report->getProductCountFromOrderStatus()
        ]);
    }
    
    public function getMostOrderedProductAndNotInStockOfYear(Report $report): JsonResponse
    {
        return $this->success([
            "product" => $report->getMostOrderedProductAndNotInStockOfYear()
        ]);
    }
}
