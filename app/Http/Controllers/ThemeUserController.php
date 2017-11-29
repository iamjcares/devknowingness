<?php

namespace Knowingness\Http\Controllers;

use Redirect;
use Entrust;
use Knowingness\Models\Page;
use Knowingness\Models\Course;
use Knowingness\Models\Menu;
use Knowingness\Models\CourseCategory;
use Knowingness\Models\PostCategory;
use Knowingness\Models\Favorite;
use Knowingness\Libraries\ThemeHelper;
use Knowingness\Models\Enrolment;
use View;
use Auth;
use Input;
use URL;
use Knowingness\User;

class ThemeUserController extends BaseController
{

    public function __construct()
    {
        $this->middleware('secure');
    }

    public static $rules = ['username' => 'required|unique:users', 'email' => 'required|email|unique:users', 'password' => 'required|confirmed'];

    public function index($username)
    {
        $user = User::where('username', '=', $username)->first();

        if (Entrust::hasRole('admin')) {
            $user->role = 'admin';
        } elseif (Entrust::hasRole('course')) {
            $user->role = 'author';
        } else {
            $user->role = 'user';
        }

        $favorites = Favorite::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
        $favorite_array = array();
        foreach ($favorites as $key => $fave) {
            array_push($favorite_array, $fave->course_id);
        }

        $courses = Course::where('active', '=', '1')->whereIn('id', $favorite_array)->take(9)->get();

        $data = array(
            'user' => $user,
            'type' => 'profile',
            'courses' => $courses,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::user', $data);
    }

    public function edit($username)
    {
        if (!Auth::guest() && Auth::user()->username == $username) {

            $user = User::where('username', '=', $username)->first();
            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'edit',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'course_categories' => CourseCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::all(),
            );
            return View::make('Theme::user', $data);
        } else {
            return Redirect::to('/');
        }
    }

    public function courses()
    {
        if (!Auth::guest()) {

            $page = Input::get('page');

            if (empty($page)) {
                $page = 1;
            }

            $enrols = Enrolment::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();

            $enrol_array = array();
            foreach ($enrols as $key => $v) {
                array_push($enrol_array, $v->course_id);
            }

            $courses = Course::where('active', '=', '1')->whereIn('id', $enrol_array)->paginate(12);

            $data = array(
                'courses' => $courses,
                'page_title' => ucfirst(Auth::user()->username) . '\'s Courses',
                'current_page' => $page,
                'page_description' => 'Page ' . $page,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'pagination_url' => URL::to('user') . '/' . Auth::user()->username . '/courses',
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

    public function update($username)
    {

        $input = array_except(Input::all(), '_method');
        $input['username'] = str_replace('.', '-', $input['username']);

        $user = User::where('username', '=', $username)->first();

        if (Auth::user()->id == $user->id) {

            if (Input::hasFile('avatar')) {
                $input['avatar'] = ImageHandler::uploadImage(Input::file('avatar'), 'avatars');
            } else {
                $input['avatar'] = $user->avatar;
            }

            if ($input['password'] == '') {
                $input['password'] = $user->password;
            } else {
                $input['password'] = Hash::make($input['password']);
            }

            if ($user->username != $input['username']) {
                $username_exist = User::where('username', '=', $input['username'])->first();
                if ($username_exist) {
                    return Redirect::to('user/' . $user->username . '/edit')->with(array('note' => 'Sorry That Username is already in Use', 'note_type' => 'error'));
                }
            }

            $user->update($input);

            return Redirect::to('user/' . $user->username . '/edit')->with(array('note' => 'Successfully Updated User Info', 'note_type' => 'success'));
        }

        return Redirect::to('user/' . Auth::user()->username . '/edit ')->with(array('note' => 'Sorry, there seems to have been an error when updating the user info', 'note_type' => 'error'));
    }

    public function billing($username)
    {

        if (Auth::user()->username == $username) {

            if (Auth::user()->role == 'admin' || Auth::user()->role == 'admin') {
                return Redirect::to('/user/' . $username . '/edit')->with(array('note' => 'This user type does not have billing info associated with their account.', 'note_type' => 'warning'));
            }

            $user = User::where('username', '=', $username)->first();

            $payment_settings = PaymentSetting::first();

            if ($payment_settings->live_mode) {
                User::setStripeKey($payment_settings->live_secret_key);
            } else {
                User::setStripeKey($payment_settings->test_secret_key);
            }

            $invoices = $user->invoices();

            $data = array(
                'user' => $user,
                'post_route' => URL::to('user') . '/' . $user->username . '/update',
                'type' => 'billing',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'course_categories' => CourseCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'payment_settings' => $payment_settings,
                'invoices' => $invoices,
                'pages' => Page::all(),
            );
            return View::make('Theme::user', $data);
        } else {
            return Redirect::to('/');
        }
    }

}
