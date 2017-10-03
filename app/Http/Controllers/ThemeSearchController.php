<?php

use \Redirect as Redirect;

class ThemeSearchController extends BaseController
{

    public function __construct()
    {
        $this->middleware('secure');
    }

    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
     */

    public function index()
    {
        $search_value = Input::get('value');

        if (empty($search_value)) {
            return Redirect::to('/');
        }
        $courses = Course::where('active', '=', 1)->where('title', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')->get();
        $posts = Post::where('active', '=', 1)->where('title', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')->get();

        $data = array(
            'courses' => $courses,
            'posts' => $posts,
            'search_value' => $search_value,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );

        return View::make('Theme::search-list', $data);
    }

}
