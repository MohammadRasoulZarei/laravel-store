<?php

namespace App\Http\Controllers\Home;

use Cart;
use App\Models\Product;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\ProductVariation;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function checkout()
    {
        $orderTotal = 0;
        $provinces = Province::all();
        $addresses = UserAddress::where('user_id', auth()->id())->get();
        return view('home.checkout', compact('addresses', 'provinces', 'orderTotal'));

    }
    public function checkCoupon(Request $req)
    {
        $req->validate([
            'code' => 'required'
        ]);
        if (auth()->check()) {
            $result = checkCouponHelper($req->code);

            if (array_key_exists('error', $result)) {
                alert()->error( 'خطا' ,$result['error']  )->showConfirmButton('حله');

                return redirect()->back();
            } else {
                alert()->success($result['success'], 'انجام شد');

                return redirect()->back();
            }
        } else {
            alert()->error('لطفا ابتدا وارد سایت شوید', 'خطا');

            return redirect()->back();
        }




    }

    public function add(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'productID' => 'required|integer',
            'qtybutton' => 'required',
        ]);

        $product = Product::findOrFail($req->productID);
        $productVariation = ProductVariation::findOrFail(json_decode($req->variation)->id);
        //  dd( $productVariation);
        if ($req->qtybutton > $productVariation->quantity) {
            alert()->warning('  تعداد درخواستی بیش از تعدا موحودی انبار است', 'خطا');

            return redirect()->back();
        }
        $rowId = $product->id . $productVariation->id;
        if (Cart::get($rowId)) {
            alert()->warning('  این محصول قبلا به سبد خریداضافه شده است', 'دقت');

            return redirect()->back();
        }

        Cart::add(
            array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $req->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            )
        );

        alert()->success('  به سبد خرید اضافه شد', 'تشکر');

        return redirect()->back();

    }

    public function index()
    {

        $cart = \Cart::getContent();
        $cartCount = \Cart::getContent()->count();
        $cartTotalPrice =\Cart::getTotal();
        $cartTotalPrice =\Cart::isEmpty();


        // dd($cart);
        return view('home.cart', compact('cart'));
    }

    public function update(Request $req)
    {
        //  dd(\Cart::getContent());
        $req->validate([
            'qtybutton' => 'required'
        ]);
        //   dd(\Cart::get(413)->attributes->quantity);
        //dd($req->all());
        foreach ($req->qtybutton as $rowId => $quantity) {

            if (\Cart::get($rowId)->attributes->quantity < $quantity) {
                alert()->warning('  تعداد درخواستی بیش از تعدا موحودی انبار است', 'خطا');
                return redirect()->back();
            }

            \Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
            )

            );
        }
        alert()->success('   سبد خرید بروزرسانی شد', 'تشکر');

        return redirect()->back();
    }

    public function delete($id)
    {
        \Cart::remove($id);
        //    if (\Cart::getContent()->count()==0) {
        //     \Cart::clear();
        //    }
        return redirect()->back();
    }
    

}
