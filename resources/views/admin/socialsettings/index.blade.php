@extends('admin.master')

@section('css')
<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }
    .make-switch{
        z-index:2;
    }
</style>
@stop


@section('content')

<div id="admin-container">
    <!-- This is where -->

    <div class="admin-section-title">
        <h3><i class="entypo-credit-card"></i> Social Settings</h3>
    </div>
    <div class="clear"></div>
    <form method="POST" action="{{ URL::to('admin/social_settings') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Facebook Login</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>Enable:</p>
                        <div class="form-group">
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" @if(isset($settings->enable_facebook_login) && $settings->enable_facebook_login)checked="checked" value="1"@else value="0"@endif name="facebook" id="facebook" />
                            </div>
                        </div>
                        <br />
                        <p>Client Key:</p>
                        <input type="text" class="form-control" name="facebook_client_id" id="facebook_client_id" placeholder="Enter Facebook Client Id" value="{{config('services.facebook.client_id')}}" />

                        <br />
                        <p>Client Secret Key:</p>
                        <input type="text" class="form-control" name="facebook_client_secret" id="facebook_client_secret" placeholder="Enter Facebook Client Secret" value="{{config('services.facebook.client_secret')}}" />

                        <br />
                        <p>Redirect URL:</p>
                        <input type="text" class="form-control" name="facebook_redirect" id="facebook_redirect" placeholder="Enter Facebook Redirect Path" value="{{config('services.facebook.redirect')}}" />

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Google Plus Login</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>Enable:</p>
                        <div class="form-group">
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" @if(isset($settings->enable_google_login) && $settings->enable_google_login)checked="checked" value="1"@else value="0"@endif name="google" id="google" />
                            </div>
                        </div>
                        <br />
                        <p>Client Key:</p>
                        <input type="text" class="form-control" name="google_client_id" id="google_client_id" placeholder="Enter Google Client Id" value="{{config('services.google.client_id')}}" />

                        <br />
                        <p>Client Secret Key:</p>
                        <input type="text" class="form-control" name="google_client_secret" id="google_client_secret" placeholder="Enter Google Client Secret" value="{{config('services.google.client_secret')}}" />

                        <br />
                        <p>Redirect URL:</p>
                        <input type="text" class="form-control" name="google_redirect" id="google_redirect" placeholder="Enter Google Redirect Path" value="{{config('services.google.redirect')}}" />

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Twitter Login</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>Enable:</p>
                        <div class="form-group">
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" @if(isset($settings->enable_twitter_login) && $settings->enable_twitter_login)checked="checked" value="1"@else value="0"@endif name="twitter" id="twitter" />
                            </div>
                        </div>
                        <br />
                        <p>Client Key:</p>
                        <input type="text" class="form-control" name="twitter_client_id" id="twitter_client_id" placeholder="Enter Twitter Client Id" value="{{config('services.twitter.client_id')}}" />

                        <br />
                        <p>Client Secret Key:</p>
                        <input type="text" class="form-control" name="twitter_client_secret" id="twitter_client_secret" placeholder="Enter Twitter Client Secret" value="{{config('services.twitter.client_secret')}}" />

                        <br />
                        <p>Redirect URL:</p>
                        <input type="text" class="form-control" name="twitter_redirect" id="twitter_redirect" placeholder="Enter Twitter Redirect Path" value="{{config('services.twitter.redirect')}}" />

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
        <input type="submit" value="Update Social Settings" class="btn btn-success pull-right" />

    </form>

    <div class="clear"></div>

</div><!-- admin-container -->

@section('javascript')
<script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
<script type="text/javascript">

$ = jQuery;

$(document).ready(function () {
    $('input[type="checkbox"]').change(function () {
        if ($(this).is(":checked")) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });
});

</script>
@stop

@stop