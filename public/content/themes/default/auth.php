<?php include('includes/header.php'); ?>
<?php if ($type == 'login'): ?>

    <h2 class="form-signin-heading">Please Login</h2>
    <form method="post" action="<?= ($settings->enable_https) ? secure_url('login') : URL::to('login') ?>" class="form-signin">
        <input type="text" class="form-control" placeholder="Email address or Username" tabindex="0" id="email" name="email" value="<?php if ($settings->demo_mode == 1): ?>demo<?php endif; ?>">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php if ($settings->demo_mode == 1): ?>demo<?php endif; ?>">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <br />
        <input type="hidden" id="redirect" name="redirect" value="<?= Input::get('redirect') ?>" />
        <a href="<?= ($settings->enable_https) ? secure_url('password/reset') : URL::to('password/reset') ?>">Forgot Password?</a>
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>

<?php elseif ($type == 'social_login'): ?>
    <h2 class="form-signin-heading">Please Login</h2>
    <div class="form-signin">
        <?php if ($settings->enable_facebook_login): ?>
            <a href="<?= route('social.login', ['facebook']) ?>" class="btn btn-block btn-lg btn-facebook"><i class="fa fa-facebook"></i> Login with Facebook</a>
        <?php endif; ?>
        <?php if ($settings->enable_google_login): ?>
            <a href="<?= route('social.login', ['google']) ?>" class="btn btn-block btn-lg btn-gplus"><i class="fa fa-google-plus"></i> Login with Google</a>
        <?php endif; ?>
        <?php if ($settings->enable_twitter_login): ?>
            <a href="<?= route('social.login', ['twitter']) ?>" class="btn btn-block btn-lg btn-twitter"><i class="fa fa-twitter"></i> Login with Twitter</a>
        <?php endif; ?>
        <p class="text-center"><strong>- or -</strong></p>
        <a href="<?= ($settings->enable_https) ? secure_url('mlogin') : URL::to('mlogin') ?>" class="btn btn-primary btn-block btn-lg">Username/Password</a>

    </div>

<?php elseif ($type == 'signup'): ?>
    <?php include('partials/signup.php'); ?>
    <!-- SHOW FORGOT PASSWORD FORM -->
<?php elseif ($type == 'forgot_password'): ?>

    <?php include('partials/form-forgot-password.php'); ?>

    <!-- SHOW RESET PASSWORD FORM -->
<?php elseif ($type == 'reset_password'): ?>

    <?php include('partials/form-reset-password.php'); ?>

<?php endif; ?>

<?php include('includes/footer.php'); ?>