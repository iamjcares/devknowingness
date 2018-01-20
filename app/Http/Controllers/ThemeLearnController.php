<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Knowingness\Http\Controllers;

use Redirect;
use Knowingness\Models\Setting;
use Knowingness\Models\Page;
use Knowingness\Models\Tag;
use Knowingness\Models\Course;
use Knowingness\Models\Enrolment;
use Knowingness\Models\Menu;
use Knowingness\Models\Favorite;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Libraries\ThemeHelper;
use View;
use Input;
use Auth;

/**
 * Description of ThemeLearnController
 *
 * @author JohnnyCares
 */
class ThemeLearnController extends BaseController
{

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($slug)
    {

        $course = Course::with(['tags', 'objectives', 'requirements', 'prerequisites', 'faqs', 'chapters'])->where('slug', '=', $slug)->first();

//Make sure course is active and user has enrolled
        $enrolment = Enrolment::where('course_id', $course->id)->where('user_id', Auth::user()->id)->first();
        if (!empty($enrolment) && $course->active) {

            $favorited = Favorite::where('user_id', '=', Auth::user()->id)->where('course_id', '=', $course->id)->first();

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
            return View::make('Theme::learn', $data);
        } else {
            return Redirect::to('course/' . $slug);
        }
    }

}
