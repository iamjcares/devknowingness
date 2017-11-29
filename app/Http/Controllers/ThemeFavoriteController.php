<?php

namespace Knowingness\Http\Controllers;

use Redirect;
use Knowingness\Models\Favorite;
use Knowingness\Models\Page;
use Knowingness\Models\Course;
use Knowingness\Models\Menu;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Libraries\ThemeHelper;
use View;
use Auth;
use Input;

class ThemeFavoriteController extends BaseController
{

    public function __construct()
    {
        $this->middleware('secure');
    }

    // Add Media Like
    public function favorite()
    {
        $course_id = Input::get('course_id');
        $favorite = Favorite::where('user_id', '=', Auth::user()->id)->where('course_id', '=', $course_id)->first();
        if (isset($favorite->id)) {
            $favorite->delete();
        } else {
            $favorite = new Favorite();
            $favorite->user_id = Auth::user()->id;
            $favorite->course_id = $course_id;
            $favorite->save();
            echo $favorite;
        }
    }

    public function show_favorites()
    {

        if (!Auth::guest()) {

            $page = Input::get('page');

            if (empty($page)) {
                $page = 1;
            }

            $favorites = Favorite::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();

            $favorite_array = array();
            foreach ($favorites as $key => $fave) {
                array_push($favorite_array, $fave->course_id);
            }

            $courses = Course::where('active', '=', '1')->whereIn('id', $favorite_array)->paginate(12);

            $data = array(
                'courses' => $courses,
                'page_title' => ucfirst(Auth::user()->username) . '\'s Favorite Courses',
                'current_page' => $page,
                'page_description' => 'Page ' . $page,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'pagination_url' => '/favorites',
                'course_categories' => CourseCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::all(),
            );

            return View::make('Theme::course-list', $data);
        } else {
            return Redirect::to('courses');
        }
    }

}
