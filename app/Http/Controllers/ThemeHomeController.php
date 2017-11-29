<?php

namespace Knowingness\Http\Controllers;

use Redirect;
use Knowingness\Models\Setting;
use Knowingness\Models\Page;
use Knowingness\Models\Course;
use Knowingness\Models\Menu;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Libraries\ThemeHelper;
use View;

class ThemeHomeController extends Controller
{

    private $courses_per_page = 12;

    public function __construct()
    {
        $this->middleware('secure');
        $settings = Setting::first();
        $this->courses_per_page = $settings->courses_per_page;
    }

    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
     */

    public function index()
    {

        if (\Input::get('theme')) {
            \Cookie::queue('theme', \Input::get('theme'), 100);
            return Redirect::to('/')->withCookie(cookie('theme', \Input::get('theme'), 100));
        }

        $data = array(
            'courses' => Course::where('active', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate($this->courses_per_page),
            'current_page' => 1,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/courses',
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );

        return View::make('Theme::home', $data);
    }

}
