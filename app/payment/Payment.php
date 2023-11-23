<?php

namespace App\payment;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\ProductVariation;
use App\Notifications\PaymentSms;
use Illuminate\Support\Facades\DB;

class Payment
{
    public static function createOrder($token, $amounts, $address_id, $gateway)
    {
        try {
            DB::beginTransaction();
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $address_id,
                'coupon_id' => session('coupon.id') ? session('coupon.id') : null,
                'total_amount' => $amounts['total_amount'],
                'delivery_amount' => $amounts['delivery_amount'],
                'coupon_amount' => $amounts['coupon_amount'],
                'paying_amount' => $amounts['paying_amount'],
                'payment_type' => 'online',

            ]);
            foreach (\Cart::getContent() as $item) {
                # code...
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->associatedModel->id,
                    'product_variation_id' => $item->attributes->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->price * $item->quantity,

                ]);
            }

            Transaction::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'amount' => $amounts['paying_amount'],
                'token' => $token,
                'gateway_name' => $gateway,

            ]);
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['error' => $th->getMessage()];
        }
    }

    public static function successUpdate($token, $refId)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::where('token', $token)->firstOrFail();
            $transaction->update([
                'status' => 1, 'ref_id' => $refId
            ]);

            Order::findOrFail($transaction->order_id)->update([
                'payment_status' => 1,
                'status' => 1
            ]);
            foreach (\Cart::getContent() as $item) {
                $variation = ProductVariation::findOrFail($item->attributes->id);
                $variation->update([
                    'quantity' => $variation->quantity - $item->quantity
                ]);
            }


            DB::commit();
            auth()->user()->notify(new PaymentSms($transaction->amount,$transaction->ref_id,$transaction->updated_at));
            \Cart::clear();
            if (session("coupon.discount")) {
                session()->forget('coupon');
            }

            return 'success';
        } catch (\Throwable $th) {
            // DB::rollBack();
            // alert()->error($th->getMessage(), 'متاسفانه');

            return ['error' => $th->getMessage()];
        }
    }
}
