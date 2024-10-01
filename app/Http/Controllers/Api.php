<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderListRequest;
use App\Http\Resources\OrderListResource;
use App\Libraries\Report;
use App\Models\Orders;
use App\Models\OrderStatuses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Api extends Controller
{
    /* 

        Doğru şekilde kurgulanırsa try catch mekanizmaları her class içerisinde yazılması gerekmez. 
        Eğer Api ile çalışılıyor ise ve header da application/json gönderilirse aşağıdaki response dönecektir. 
        Bu application/json olayını kalıcı ekleme yöntemleride mevcuttur apiler için daha doğru bir çözümdür. 
        Development esnasında hatalar ile birlikte productionda sadece 500 ve message return'u döner.

        routes/api.php içerisinde bulunan ürün ile ilişkili 4 endpoint 
        ProductController.php içerisinde,
        orders endpoint'i ile benzer yapıda olacak şekilde implement edilmelidir. 
        metnine istinaden anladığım yapısal returnlerı bu akışta istiyorsunuz buna göre geliştirme yapıyorum normalde classlarda trycatch kullanmam 
        
    */
    public function orders(OrderListRequest $request)
    {
        try {
            $orders = Orders::query()
                ->with(['products', 'customer', 'status'])
                ->when($request->order_no, function($q) use ($request){
                    $q->where("order_no", $request->order_no);
                })
                ->where('customer_id', $request->get('customer_id') )
                ->orderBy('id', 'DESC')
                ->get();

            $data = OrderListResource::collection($orders);

            return $this->success([
                'orders' => $data->resolve(),
            ],Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error();
        }
    }

    public function getStatusStats(){
        $report = new Report();
        dd(
            $report->getMostOrderedProductsThatIsNotInStock(),
        );
    }
}
