
<?php

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;


$e = 0;
function ed($var, $colorClass = '', $title = "")
{
    global $e;
    if ($e == 0) {
        $colorClass = 'background-color: #D8E9FF';
        $e++;
    } else {
        $e = 0;
        $colorClass = ' background-color: #d9f2d9';
    }
    if ($var == false) {
        echo "<span style='  width: 80%;
        display: block;
        margin: 5px auto;
        padding: 5px;
        border-radius: 5px;
        font-family: monospace;  {$colorClass}' >$title";
        var_dump($var);
        echo "</span>";
        return;
    }
    if (is_array($var)) {
        echo "<pre style='  width: 80%;
        display: block;
        margin: 5px auto;
        padding: 5px;
        border-radius: 5px;
        font-family: monospace;  {$colorClass}'>$title";
        print_r($var);
        echo "</pre>";
    } elseif (is_string($var)) {
        echo "<span style='  width: 80%;
        display: block;
        margin: 5px auto;
        padding: 5px;
        border-radius: 5px;
        font-family: monospace;  {$colorClass}'>$title" . $var . "</span>";
    } elseif (is_object($var)) {
        echo "<pre style='  width: 80%;
        display: block;
        margin: 5px auto;
        padding: 5px;
        border-radius: 5px;
        font-family: monospace;  {$colorClass}' >$title";
        var_dump($var);
        echo "</pre>";
    } else {
        echo "<pre style='  width: 80%;
        display: block;
        margin: 5px auto;
        padding: 5px;
        border-radius: 5px;
        font-family: monospace;  {$colorClass}' >$title";
        var_dump($var);
        echo "</pre>";
    }
}
function mygenerateFileName($name)
{
    return date('Y_m_d-H_i_s-') . $name;
}
function convertToMiladi($date)
{
    if ($date == null)
        return null;

    $splited = preg_split('/[\/\s]/', $date);

    $eng = jalali_to_gregorian($splited[0], $splited[1], $splited[2], '-');
    return $eng . ' ' . $splited[3];
}


function discountAmount()
{

    $discountAmount = 0;

    foreach (\Cart::getContent() as $item) {


        if ($item->attributes->is_sale) {
            $discountAmount += $item->quantity * ($item->attributes->price - $item->price);
        }
    }
    return   $discountAmount;
}
function cartTotalDelivery()
{
    $discountAmount = 0;
    foreach (\Cart::getContent() as $item) {
        $discountAmount += $item->associatedModel->delivery_amount;
    }
    return   $discountAmount;
}

function checkCouponHelper($code)
{
    $coupon = Coupon::where('code', $code)->first();
    // dd(  $coupon);
    if ($coupon) {
        if ($coupon->expired_at < Carbon::now()) {
            session()->forget('coupon');

            return ['error' => 'کد تخفیف  منقضی شده است'];
        }
    } else {
        session()->forget('coupon');
        return ['error' => 'کد تخفیف وجود ندارد'];
    }
    if (!Order::where(['user_id' => auth()->id(), 'coupon_id' => $coupon->id, 'payment_status' => 1])->exists()) {
        $tatal = \Cart::getTotal();

        if ($coupon->getRawOriginal('type') == 'percentage') {
            // dd('ff');

            $amount = (($tatal * $coupon->percentage) / 100) > $coupon->max_percentage_amount ?
             $coupon->max_percentage_amount : ($tatal * $coupon->percentage) / 100;

        } else {
            $amount = $coupon->amount;
        }
        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'discount' => $amount]);
    } else {
        session()->forget('coupon');
        return ['error' => 'شما قبلا از این کد تخفیف استفاده کرده اید'];
    }


    return ['success' => 'کد تخفیف اعمال شد'];
}
function CartFinalTotal()
{
    if (session('coupon.discount')) {
        return (cartTotalDelivery() + \Cart::getTotal()) - session('coupon.discount') > 0 ?
         (cartTotalDelivery() + \Cart::getTotal()) - session('coupon.discount') : 0;
    }
    return cartTotalDelivery() + \Cart::getTotal();
}
