<?php
$sidebar_courses = \Knowingness\Models\Course::where('active', '=', '1')->orderByRaw("RAND()")->take(6)->get();
$sidebar_posts = Knowingness\Models\Post::where('active', '=', '1')->orderByRaw("RAND()")->take(6)->get();
?>

<div id="sidebar">

    <h3>Courses You May Like</h3>

    <div class="row">
        <?php foreach ($sidebar_courses as $course): ?>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <article class="block">
                    <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('course') : URL::to('course') ?><?= '/' . $course->slug ?>">
                        <div class="thumbnail-overlay"></div>
                        <span class="play-button"></span>
                        <img src="<?= ImageHandler::getImage($course->image, 'medium') ?>">
                        <div class="details">
                            <h2><?= $course->title; ?></h2>
                        </div>
                    </a>
                </article>
            </div>

        <?php endforeach; ?>
    </div>


    <h3>Posts You May Like</h3>

    <div class="row">
        <?php foreach ($sidebar_posts as $post): ?>

            <?php $post_description = preg_replace('/^\s+|\n|\r|\s+$/m', '', strip_tags($post->body)); ?>

            <div class="col-md-12">
                <article class="block list">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('post') : URL::to('post') ?><?= '/' . $post->slug ?>">
                                <div class="thumbnail-overlay"></div>
                                <img src="<?= ImageHandler::getImage($post->image, 'medium') ?>">
                            </a>
                        </div>
                        <div class="block-contents col-md-6">
                            <h2><a href="<?= ($settings->enable_https) ? secure_url('post') : URL::to('post') ?><?= '/' . $post->slug ?>"><?= $post->title; ?></a></h2>
                            <p class="date"><?= date("F jS, Y", strtotime($post->created_at)); ?></p>
                            <div class="clear"></div>
                            <?php if (!empty($post->category)): ?>
                                <p class="category"><span>in </span> <a href="/posts/category/<?= $post->category->slug; ?>"><?= $post->category->name; ?></a></p>
                                <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>

        <?php endforeach; ?>
    </div>


</div>