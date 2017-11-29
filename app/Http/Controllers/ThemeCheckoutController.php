<?php

namespace Knowingness\Http\Controllers;

use \Auth as Auth;

namespace Knowingness\Http\Controllers;

use Redirect;
use Knowingness\Models\PaymentSetting;
use Knowingness\Models\Page;
use Knowingness\Models\Cart;
use Knowingness\Models\Menu;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Libraries\ThemeHelper;
use View;

class ThemeCheckoutController extends BaseController
{

    public function __construct()
    {
        $this->middleware('secure');
    }

    public function index()
    {
        $data = array(
            'type' => 'index',
            'payment_settings' => PaymentSetting::first(),
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::checkout', $data);
    }

    public function getCart()
    {
        return $cart = Cart::with(['courses'])->where([['user_id', '=', Auth::user()->id], [ 'instance', '=', 'cart']])->orderBy('created_at', 'desc')->first();
    }

}
