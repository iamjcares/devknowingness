<?php

namespace Knowingness\Http\Controllers;

use Redirect;
use Knowingness\Models\Page;
use Knowingness\Models\Menu;
use Knowingness\Models\Cart;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Libraries\ThemeHelper;
use View;
use Auth;

class ThemeWishListController extends BaseController
{

    public function addItem()
    {
        $course = Input::get('course_id');
        $data = ['user_id' => Auth::user()->id, 'instance' => 'wish'];
        $cart = Cart::firstOrCreate($data);

        if (!$cart->courses->contains($course)) {
            $cart->courses()->attach($course);
            return Redirect::to('courses')->with(array('note' => 'Course Successfully Added to Cart!', 'note_type' => 'success'));
        }
        return Redirect::to('courses')->with(array('note' => 'Course Already added to WishList!', 'note_type' => 'success'));
    }

    public function removeItem()
    {
        $course = Input::get('course_id');
        $data = ['user_id' => Auth::user()->id, 'instance' => 'wish'];
        $cart = Cart::firstOrCreate($data);

        foreach ($cart->courses as $c) {
            if ($c->id == $course) {
                $cart->courses()->detach($course);
                return Redirect::to('courses')->with(array('note' => 'Course Successfully removed from WishList!', 'note_type' => 'success'));
            }
        }
        return Redirect::to('courses')->with(array('note' => 'Course not in wishlist!', 'note_type' => 'error'));
    }

    public function clearCart()
    {
        $data = ['user_id' => Auth::user()->id, 'instance' => 'cart'];
        $cart = Cart::firstOrCreate($data);
        $cart->courses()->sync([]);
    }

    public function index()
    {
        if (!Auth::guest()):

            $cart = Cart::with(['courses'])->where([['user_id', '=', Auth::user()->id], [ 'instance', '=', 'wish']])->orderBy('created_at', 'desc')->first();

            $data = array(
                'courses' => $cart->courses,
                'subtotal' => 0,
                'page_title' => ucfirst(Auth::user()->username) . '\'s Wish List',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'course_categories' => CourseCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::all(),
            );

            return View::make('Theme::cart', $data);

        else:
            return Redirect::to('courses');
        endif;
    }

}
