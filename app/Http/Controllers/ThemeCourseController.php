<?php

namespace Knowingness\Http\Controllers;

use Redirect;
use Knowingness\Models\Setting;
use Knowingness\Models\Page;
use Knowingness\Models\Tag;
use Knowingness\Models\Course;
use Knowingness\Models\Menu;
use Knowingness\Models\Favorite;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Libraries\ThemeHelper;
use Knowingness\Models\Enrolment;
use View;
use Input;
use Auth;

class ThemeCourseController extends BaseController
{

    private $courses_per_page = 12;

    public function __construct()
    {
        $this->middleware('secure');
        $settings = Setting::first();
        $this->courses_per_page = $settings->courses_per_page;
    }

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($slug)
    {
        $course = Course::with(['tags', 'objectives', 'requirements', 'prerequisites', 'faqs', 'chapters'])->where('slug', '=', $slug)->first();
        $enrolment = Enrolment::where('course_id', $course->id)->where('user_id', Auth::user()->id)->first();

        if (empty($enrolment || !$course->active)) {
            //Make sure course is active
            if ((!Auth::guest() && Auth::user()->hasRole('admin')) || $course->active) {

                $favorited = false;
                if (!Auth::guest()) {
                    $favorited = Favorite::where('user_id', '=', Auth::user()->id)->where('course_id', '=', $course->id)->first();
                }

                // load videos into chapters.
                $chapters = $course->chapters()->with('lectures')->get();

                //$view_increment = $this->handleViewCount($id);
                $data = array(
                    'course' => $course,
                    'chapters' => $chapters,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'view_increment' => true,
                    'favorited' => $favorited,
                    'course_categories' => CourseCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::all(),
                );
                return View::make('Theme::course', $data);
            } else {
                return Redirect::to('courses')->with(array('note' => 'Sorry, this course is no longer active.', 'note_type' => 'error'));
            }
        } else {
            return Redirect::to('course/learn/' . $slug);
        }
    }

    /*
     * Page That shows the latest course list
     *
     */

    public function courses()
    {
        $page = Input::get('page');
        if (!empty($page)) {
            $page = Input::get('page');
        } else {
            $page = 1;
        }

        $data = array(
            'courses' => Course::where('active', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate($this->courses_per_page),
            'page_title' => 'All Courses',
            'page_description' => 'Page ' . $page,
            'current_page' => $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/courses',
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::course-list', $data);
    }

    public function tag($tag)
    {
        $page = Input::get('page');
        if (!empty($page)) {
            $page = Input::get('page');
        } else {
            $page = 1;
        }

        if (!isset($tag)) {
            return Redirect::to('courses');
        }

        $tag_name = $tag;

        $tag = Tag::where('name', '=', $tag)->first();

        $tags = CourseTag::where('tag_id', '=', $tag->id)->get();

        $tag_array = array();
        foreach ($tags as $key => $tag) {
            array_push($tag_array, $tag->course_id);
        }

        $courses = Course::where('active', '=', '1')->whereIn('id', $tag_array)->paginate($this->courses_per_page);

        $data = array(
            'courses' => $courses,
            'current_page' => $page,
            'page_title' => 'Courses tagged with "' . $tag_name . '"',
            'page_description' => 'Page ' . $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/courses/tags/' . $tag_name,
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );

        return View::make('Theme::course-list', $data);
    }

    public function category($category)
    {
        $page = Input::get('page');
        if (!empty($page)) {
            $page = Input::get('page');
        } else {
            $page = 1;
        }

        $cat = CourseCategory::where('slug', '=', $category)->first();

        $parent_cat = CourseCategory::where('parent_id', '=', $cat->id)->first();

        if (!empty($parent_cat->id)) {
            $parent_cat2 = CourseCategory::where('parent_id', '=', $parent_cat->id)->first();
            if (!empty($parent_cat2->id)) {
                $courses = Course::where('active', '=', '1')->where('course_category_id', '=', $cat->id)->orWhere('course_category_id', '=', $parent_cat->id)->orWhere('course_category_id', '=', $parent_cat2->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
            } else {
                $courses = Course::where('active', '=', '1')->where('course_category_id', '=', $cat->id)->orWhere('course_category_id', '=', $parent_cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
            }
        } else {
            $courses = Course::where('active', '=', '1')->where('course_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
        }


        $data = array(
            'courses' => $courses,
            'current_page' => $page,
            'category' => $cat,
            'page_title' => 'Courses - ' . $cat->name,
            'page_description' => 'Page ' . $page,
            'pagination_url' => '/courses/category/' . $category,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );

        return View::make('Theme::course-list', $data);
    }

}
