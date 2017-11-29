<?php include('includes/header.php'); ?>

<div class="container user">

    <?php if (isset($type) && $type == 'profile'): ?>

        <div id="user-badge">
            <img src="<?= Config::get('site.uploads_url') . 'avatars/' . $user->avatar ?>" />
            <h2 class="form-signin-heading"><?= $user->name ?></h2>
            <div class="label label-info"><?= ucfirst($user->role) ?> User</div>
            <p class="member-since">Member since: <?= $user->created_at ?></p>

            <a href="<?= ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?= '/' . $user->username . '/edit' ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
        </div>

        <h2><?= ucfirst($user->username) ?>'s Favorites </h2>
        <div class="heading-divider"></div>
        <div class="row">
            <?php include('partials/course-loop.php'); ?>
            <div class="clear"></div>
            <a class="user-favorites" href="/favorites">View All Favorites</a>
        </div>


    <?php elseif (isset($type) && $type == 'edit'): ?>

        <h4 class="subheadline"><i class="fa fa-edit"></i> Update Your Profile Info</h4>
        <div class="clear"></div>

        <form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
            <div id="user-badge">
                <img src="<?= Config::get('site.uploads_url') . 'avatars/' . $user->avatar ?>" />
                <label for="avatar">Avatar</label>
                <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
            </div>

            <div class="well">
                <?php if ($errors->first('username')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('username'); ?></div><?php endif; ?>
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php if (!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
            </div>

            <div class="well">
                <?php if ($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php if (!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
            </div>

            <div class="well">
                <label for="password">Password (leave empty to keep your original password)</label>
                <input type="password" class="form-control" name="password" id="password" value="" />
            </div>

            <div class="well">
                <label for="role" style="margin-bottom:10px;">User Type</label>
                <?php if (Entrust::hasRole('admin')): ?>
                    <div class="label label-success"><i class="fa fa-star"></i> Admin Account</div>
                    <div class="clear"></div>
                <?php elseif (Entrust::hasRole('author')): ?>
                    <div class="label label-danger"><i class="fa fa-life-saver"></i> Author Account</div>
                    <div class="clear"></div>
                <?php elseif (Entrust::hasRole('user')): ?>
                    <div class="label label-primary"><i class="fa fa-user"></i> Student Account</div>
                    <div class="clear"></div>
                <?php endif; ?>
            </div>
            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
            <input type="submit" value="Update Profile" class="btn btn-primary" />

            <div class="clear"></div>
        </form>

    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>