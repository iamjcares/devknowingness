<?php

use \Redirect as Redirect;

class AdminSocialSettingsController extends Controller
{

    public function index()
    {
        $data = array(
            'admin_user' => Auth::user(),
            'settings' => Setting::first(),
        );
        return View::make('admin.socialsettings.index', $data);
    }

    public function save_social_settings()
    {

        $input = Input::all();
        $settings = Setting::first();


        $validation = Validator::make($input, [
                    'facebook_client_id' => 'required_if:facebook,1',
                    'facebook_client_secret' => 'required_if:facebook,1',
                    'facebook_redirect' => 'required_if:facebook,1',
                    'google_client_id' => 'required_if:google,1',
                    'google_client_secret' => 'required_if:google,1',
                    'google_redirect' => 'required_if:google,1',
                    'twitter_client_id' => 'required_if:twitter,1',
                    'twitter_client_secret' => 'required_if:twitter,1',
                    'twitter_redirect' => 'required_if:twitter,1',
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation)->withInput();
        }

        $services = ConfigHelper::getServices();
        if (isset($input['facebook'])) {
            $services['facebook']['client_id'] = $input['facebook_client_id'];
            $services['facebook']['client_secret'] = $input['facebook_client_secret'];
            $services['facebook']['redirect'] = $input['facebook_redirect'];
        }
        if (isset($input['google'])) {
            $services['google']['client_id'] = $input['google_client_id'];
            $services['google']['client_secret'] = $input['google_client_secret'];
            $services['google']['redirect'] = $input['google_redirect'];
        }
        if (isset($input['twitter'])) {
            $services['twitter']['client_id'] = $input['twitter_client_id'];
            $services['twitter']['client_secret'] = $input['twitter_client_secret'];
            $services['twitter']['redirect'] = $input['twitter_redirect'];
        }

        $filename = base_path() . config('paths.SERVICE_PATH');
        File::put($filename, var_export($services, true));
        File::prepend($filename, '<?php return ');
        File::append($filename, ';');

        $settings->enable_facebook_login = isset($input['facebook']) ? 1 : 0;
        $settings->enable_google_login = isset($input['google']) ? 1 : 0;
        $settings->enable_twitter_login = isset($input['twitter']) ? 1 : 0;

        $settings->save();

        return Redirect::to('admin/social_settings')->with(array('note' => 'Successfully Updated Social Settings!', 'note_type' => 'success'));
    }

}
