<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<div class="row" id="signup-form">

    <form method="POST" action="<?= ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="signup-form">

        <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">

        <div class="panel panel-default registration">

            <div class="panel-heading">

                <div class="row">

                    <h1 class="panel-title col-lg-7 col-md-8 col-sm-6"><?= ThemeHelper::getThemeSetting(@$theme_settings->signup_message, 'Signup to Gain access to all content on the site.') ?></h1>

                    <div class="cc-icons col-lg-5 col-md-4">
                        <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
                    </div>
                </div>

            </div><!-- .panel-heading -->

            <div class="panel-body">

                <fieldset>
                    <?php $name_error = $errors->first('name'); ?>
                    <?php if (!empty($errors) && !empty($name_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('name'); ?></div>
                    <?php endif; ?>
                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-4 control-label" for="name">Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name'); ?>" />
                        </div>
                    </div>

                    <?php $username_error = $errors->first('username'); ?>
                    <?php if (!empty($errors) && !empty($username_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('username'); ?></div>
                    <?php endif; ?>
                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-4 control-label" for="username">Username</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username'); ?>" />
                        </div>
                    </div>


                    <?php $email_error = $errors->first('email'); ?>
                    <?php if (!empty($errors) && !empty($email_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('email'); ?></div>
                    <?php endif; ?>
                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-4 control-label" for="email">Email Address</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="email" name="email" value="<?= old('email'); ?>">
                        </div>
                    </div>

                    <?php $password_error = $errors->first('password'); ?>
                    <?php if (!empty($errors) && !empty($password_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('password'); ?></div>
                    <?php endif; ?>
                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-4 control-label" for="password">Desired Password</label>

                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    <?php $confirm_password_error = $errors->first('password_confirmation'); ?>
                    <?php if (!empty($errors) && !empty($confirm_password_error)): ?>
                        <div class="alert alert-danger"><?= $errors->first('password_confirmation'); ?></div>
                    <?php endif; ?>
                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-4 control-label" for="password_confirmation">Confirm Password</label>

                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                </fieldset>
            </div><!-- .panel-body -->

            <div class="panel-footer clearfix">
                <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>

                <div class="pull-right sign-up-buttons">
                    <button class="btn btn-primary" type="submit" name="create-account">Sign Up Today</button>
                    <a href="/login" class="btn">Or Log In</a>
                </div>


            </div><!-- .panel-footer -->

        </div><!-- .panel -->
    </form>
</div><!-- #signup-form -->
