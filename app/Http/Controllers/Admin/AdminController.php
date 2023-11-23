<?php

namespace App\Http\Controllers\Admin;


use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Darryldecode\Cart\ItemCollection;
use Hekmatinasser\Verta\Facades\Verta;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

class AdminController extends Controller
{
    public function dashboard()
    {
        $month=12;

      $successTransactions=Transaction::getData($month,1);
      $faildTransactions=Transaction::getData($month,0);

      $cs=$successTransactions->count();
      $cf= $faildTransactions->count();
      //dd($successTransactions,$faildTransactions);
        $successline=$this->chart($successTransactions,$month);
        $unsuccessline=$this->chart($faildTransactions,$month);
   // dd($successline, $unsuccessline);


     return view('admin.dashboard',[
            'successline'=>array_values($successline),
            'monthNames'=>array_keys($successline),
            'unsuccessline'=>array_values($unsuccessline),
            'cs'=>$cs,
            'cf'=>$cf,
     ]);
    }
    public function orderIndex()
    {
        $orders=Order::latest()->paginate(10);
        return view('admin.orders.index',compact('orders'));
    }
    public function orderShow(Order $order)
    {
       // dd($order->coupon);
        return view('admin.orders.show',compact('order'));
    }
    public function transactionIndex()
    {
        $transactions=Transaction::latest()->paginate(3);
        return view('admin.transactions.index',compact('transactions'));
    }

    // helper classes part
    public function chart($transaction,$month)
    {

        $monthes = $transaction->map(function ($item) {
            return verta($item->created_at)->format('%B %y');
        });
        $amounts = $transaction->map(function ($item) {
            return $item->amount;
        });
       
        $result=[];
        foreach ($monthes as $k => $v) {
            if (!isset($result[$v])) {
                $result[$v] = 0;
            }
            $result[$v] += $amounts[$k];
        }


        if (count($result) != $month) {

            for ($i = 0; $i < $month; $i++) {

                $monthNames[verta()->subMonths($i)->format('%B %y')] = 0;
            }

           return array_reverse(array_merge($monthNames, $result));
        }
       return $result;

    }
    public function chart2($transaction,$month){

        $monthes=$transaction->map(function($item){
            return verta($item->created_at)->format('%B %y');
        });
        $amounts=$transaction->map(function($item){
            return $item->amount;
        });
        foreach ($monthes as $key => $month) {
            if (empty($result[$month])) {
                $result[$month]=0;
            }
            $result[$month]+=$amounts[$key];
        }

    }
}
