<?php

namespace App\Http\Controllers\Home;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\payment\Zarinpal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;




class PaymentController extends Controller
{
    public function payment(Request $req)
    {

        $validate = Validator::make($req->all(), [
            'address_id' => 'required|integer',
            'payment_method' => 'required'
        ]);
        if ($validate->fails()) {

            if ($validate->errors()->get('address_id')) {
                alert()->error('لطفا یک ادرس وارد کنید', "خطا");
                return back();
            }
        }
        #1
        $checkCart = $this->checkCart();
        //  dd($checkCart,isset($checkCart['error']));
        if (isset($checkCart['error'])) {

            $error = $checkCart['error'];
            switch ($error) {
                case isset($error['empty']):
                    //dd('empty',$error['empty']);
                    alert()->error('   سبد خرید  خالی است', 'دقت کنید');
                    return redirect()->route('home.index');
                    break;
                case isset($error['price']):
                    //  dd('price',$error['price']);

                    $itemName = $this->addToCart($error['price']);
                    alert()->error("تغییر قیمت در محصول $itemName اتفاق افتاده است", ' تغییرات!');
                    return redirect()->back();
                    break;
                case isset($error['quantity']):
                    // dd('quantity',$error['quantity']);
                    $itemName = \Cart::get($error['quantity'])->name;
                    \Cart::remove($error['quantity']);
                    alert()->error("   تعداد کالای خواسته شده برای $itemName  موجود نیست  لطفا مجدد محصول را انتخاب کنید", ' تغییرات!');
                    return redirect()->back();
                    break;

                default:
                    dd('خطا');
                    break;
            }
        }
        #2
        $checkCoupon = $this->checkCoupon();
        // dd($checkCoupon);
        if (isset($checkCoupon['error'])) {
            alert()->warning($checkCoupon['error'], 'خطا');

            return redirect()->back();
        }
        #3
        if ($req->payment_method == 'zarinpal') {

            $result = Zarinpal::send($checkCoupon, $req->address_id);
            if (isset($reuslt['error'])) {

                alert()->warning('شکست', 'خطا هنگام ارسال به درگاه پرداخت')->showConfirmButton('حله');
                return redirect()->back();
            }
           
            return redirect($result);
        }
        if ($req->payment_method == 'pay') {
            alert()->error('ناموفق', "با ارزش پوزش این درگاه پرداخت غیرفعال است لطفا با درگاه دیگر اقدام کنید!")->showConfirmButton('بسیار خب');

            return redirect()->back();
        }
    }

    public function verify($gate)
    {
        if ($gate == 'zarinpal') {

            $result = Zarinpal::verify($_GET['Authority']);
            if (isset($result['error'])) {
                //alert()->error('شکست', 'عملیات پرداخت ناموفق بود')->showConfirmButton('بسیار خب');
                alert()->error($result['error'], 'شکست')->showConfirmButton('بسیار خب');
                return redirect()->back();
            }
            alert()->success('عملیات موفق', "محصولات خریداری شدن")->showConfirmButton('بسیار خب');
            return redirect()->route('home.index');
        } else {
            dd('wrong-callback');
        }
    }

    public function checkCart()
    {
        if (\Cart::isEmpty()) {
            return ['error' => ['empty' => 'سبد خرید خالی است']];
        }
        // dd(\Cart::getContent()->first());
        foreach (\Cart::getContent() as $item) {
            $variation = ProductVariation::findOrFail($item->attributes->id);
            $price = $variation->is_sale ? $variation->sale_price : $variation->price;
            if ($item->price != $price) {
                return ['error' => ['price' => $item->id]];
            }
            if ($item->quantity > $variation->quantity) {
                return ['error' => ['quantity' => $item->id]];
            }
        }

        return true;
    }

    public function addToCart($itemID)
    {
        $item = \Cart::get($itemID);

        $productVariation = ProductVariation::findOrFail($item->attributes->id);

        \Cart::update(
            $itemID,
            array(

                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
            )
        );


        return $item->name;
    }
    public function checkCoupon()
    {
        if (session('coupon.discount')) {
            $couponCheck = checkCouponHelper(session('coupon.code'));
            if (isset($couponCheck['error'])) {
                session()->forget('coupon');
                return $couponCheck;
            }
        }


        return [
            'total_amount' => (\Cart::getTotal() + discountAmount()),
            'delivery_amount' => cartTotalDelivery(),
            'coupon_amount' => session('coupon.discount') ? session('coupon.discount') : 0,
            'paying_amount' => CartFinalTotal(),
        ];
    }
}
