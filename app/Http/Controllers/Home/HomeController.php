<?php

namespace App\Http\Controllers\Home;

use Carbon\Carbon;
use App\Models\Banner;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ghasedak\Laravel\GhasedakFacade;
use Artesaos\SEOTools\Facades\SEOTools;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class HomeController extends Controller
{

    public function contactUs(Request $req)
    {
        if (isset($_POST['email'])) {
            //dd($_POST,$req->all());
            $req->validate([
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'text' => 'required|min:10',
                'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
            ]);
            ContactUs::create($req->all());
            alert()->success(' تشکر', "پیام شما ارسال شد");
            return redirect()->back();
        }
        $config = [
            'addresses' => ['کرمان میدان ازادی ساختمان امید طبقه اول'],
            'telephones' => ['0345128469', '034158894248', '09133814509'],
            'longitude' => 30.288611,
            'latitude' => 57.051661,
            'socials' => [
                'telegram' => '@rasoulTelegram',
                'instagram' => '@rasoulInstagram',
            ],

        ];
        return view('home.contactUs', compact('config'));
    }
    public function aboutUs()
    {
        $banners = Banner::where('is_active', 1)->orderBy('priority')->get();
        return view('home.aboutUs', compact('banners'));
    }

    public function index()
    {
        if (session()->has('loginLand')) {
            $path=session('loginLand');
            session()->forget('loginLand');
           return redirect($path);
        }
        SEOTools::setTitle('journab');
        SEOTools::setDescription('This is my home page');
        SEOTools::setCanonical('https://codecasts.com.br/lesson');

        SEOTools::opengraph()->setUrl(route('home.index'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::opengraph()->addProperty('description', 'descriptin for socials');

        SEOTools::twitter()->setSite('@LuizVinicius73');

        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');

        $category_parents = Category::where('parent_id', 0)->get();
        $sliders = Banner::where('type', 'slider')->where('is_active', 1)->orderBy('priority')->get();
        $banners = Banner::where('is_active', 1)->orderBy('priority')->get();
        $products = Product::get();
        //   $product=Product::find(1);
        //   dd($product->sale_price);
        // example:




        return view('home.index', compact('sliders', 'banners', 'products'));
    }

    public function showProduct(Product $product)
    {
        //   $comment=$product->comments()->latest()->with('user')->first();
        // $comment=Comment::find(1);
        //dd();
        ///if (!auth()->user()->rated)
        //dd($product->quantity_status);

        return view('home.product', compact('product'));
    }
}
