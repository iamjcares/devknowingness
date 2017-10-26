<?php

use \Auth as Auth;
use \HelloVideo\User;
use \HelloVideo\Role;
use \Redirect as Redirect;
use Illuminate\Contracts\Auth\PasswordBroker;

//use Socialite;

class ThemeAuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('secure');
        $this->middleware('guest', ['except' => 'logout']);
    }

    /*
      |--------------------------------------------------------------------------
      | Auth Controller
      |--------------------------------------------------------------------------
     */

    public function login_form()
    {
        $this->middleware('guest');
        $data = array(
            'type' => 'login',
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::auth', $data);
    }

    public function social_form()
    {
        if (!Auth::guest()) {
            return Redirect::to('/');
        }
        $data = array(
            'type' => 'social_login',
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::auth', $data);
    }

    public function signup_form()
    {
        $this->middleware('guest');
//        if (!Auth::guest()) {
//            return Redirect::to('/');
//        }
        $data = array(
            'type' => 'signup',
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'payment_settings' => PaymentSetting::first(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::auth', $data);
    }

    public function login()
    {

        // get login POST data
        $email_login = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );

        $username_login = array(
            'username' => Input::get('email'),
            'password' => Input::get('password')
        );

        if (Auth::attempt($email_login) || Auth::attempt($username_login)) {
            $user = Auth::user();
            if (!$user->hasRole('user')) {
                $userRole = Role::where('name', '=', 'user')->first();
                $user->attachRole($userRole);
            }

            $redirect = (Input::get('redirect', 'false')) ? Input::get('redirect') : '/';
            return Redirect::to($redirect)->with(array('note' => 'You have been successfully logged in.', 'note_type' => 'success'));
        } else {

            $redirect = (Input::get('redirect', false)) ? '?redirect=' . Input::get('redirect') : '';
            // auth failure! redirect to login with errors
            return Redirect::to('login' . $redirect)->with(array('note' => 'Invalid login, please try again.', 'note_type' => 'error'));
        }
    }

    public function signup()
    {

        $user_data = array('name' => Input::get('name'), 'username' => Input::get('username'), 'email' => Input::get('email'), 'password' => Hash::make(Input::get('password')));

        $input = Input::all();

        $validation = Validator::make($input, User::$rules);

        if ($validation->fails()) {
            return Redirect::to('/signup')->with(array('note' => 'Sorry, there was an error creating your account.', 'note_type' => 'error', 'messages'))->withErrors($validation)->withInput(\Request::only('name', 'username', 'email'));
        }

        $user = new User($user_data);
        $userRole = Role::where('name', '=', 'user')->first();
        $user->save();
        $user->attachRole($userRole);

        Auth::loginUsingId($user->id);
        return Redirect::to('/')->with(array('note' => 'Welcome! Your Account has been Successfully Created!', 'note_type' => 'success'));
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        $user_detail = Socialite::driver($provider)->stateless()->user();
        $redirect = (Input::get('redirect', 'false')) ? Input::get('redirect') : '/';

        $data = ['email' => $user_detail->getEmail()];
        Auth::login(User::firstOrCreate($data));
        $user = Auth::user();

        if (intval($user->confirmed) === 1) {
            // user already exist
            if (!$user->hasRole('user')) {
                $userRole = Role::where('name', '=', 'user')->first();
                $user->attachRole($userRole);
            }
        } else {
            $user->name = $user_detail->getName();
            $username = str_replace(' ', '_', $user_detail->getNickname());
            if (empty($username)) {
                $username = $user_detail->getEmail();
            }
            $user->username = $username;
            $userRole = Role::where('name', '=', 'user')->first();
            $user->attachRole($userRole);
            $user->confirmed = 1;
            $user->provider = $provider;
            $avatar = $user_detail->getAvatar();
            if (!empty($avatar)) {
                $user->avatar = ImageHandler::uploadImage($avatar, 'avatars', $user->username, 'url');
            }
            $user->save();

            // creating a profile for the new user!
            $profile = $user->profile ? : new Profile();
            $profile->user()->associate($user);
            $profile->photo = $user->avatar;
            $profile->save();
            return Redirect::to($redirect)->with(array('note' => 'Welcome! Your Account has been Successfully Created!', 'note_type' => 'success'));
        }

        return Redirect::to($redirect)->with(array('note' => 'You have been successfully logged in.', 'note_type' => 'success'));
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/')->with(array('note' => 'You have been successfully logged out', 'note_type' => 'success'));
    }

    // ********** RESET PASSWORD ********** //
    public function password_reset()
    {
        $data = array(
            'type' => 'forgot_password',
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'payment_settings' => PaymentSetting::first(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::auth', $data);
    }

    // ********** RESET REQUEST ********** //
    public function password_request()
    {
        $credentials = array('email' => Input::get('email'));
        $response = Password::sendResetLink($credentials, function($message) {
                    $message->subject('Password Reset Info');
                });

        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                return Redirect::to('login')->with(array('note' => trans($response), 'note_type' => 'success'));

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->with(array('note' => trans($response), 'note_type' => 'error'));
        }
    }

    // ********** RESET PASSWORD TOKEN ********** //
    public function password_reset_token($token)
    {
        $data = array(
            'type' => 'reset_password',
            'token' => $token,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'payment_settings' => PaymentSetting::first(),
            'course_categories' => CourseCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::all(),
        );
        return View::make('Theme::auth', $data);
    }

    // ********** RESET PASSWORD POST ********** //
    public function password_reset_post(Request $request)
    {

        $credentials = $credentials = array('email' => Input::get('email'), 'password' => Input::get('password'), 'password_confirmation' => Input::get('password_confirmation'), 'token' => Input::get('token'));



        $response = Password::reset($credentials, function($user, $password) {
                    $user->password = \Hash::make($password);

                    $user->save();
                });

        switch ($response) {
            case PasswordBroker::PASSWORD_RESET:
                return Redirect::to('login')->with(array('note' => 'Your password has been successfully reset. Please login below', 'note_type' => 'success'));

            default:
                return redirect()->back()->with(array('note' => trans($response), 'note_type' => 'error'));
        }
    }

}
