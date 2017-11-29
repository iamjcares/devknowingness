<?php foreach ($courses as $course): ?>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <article class="block">
            <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('course') : URL::to('course') ?><?= '/' . $course->slug ?>">
                <div class="thumbnail-overlay"></div>
                <span class="play-button"></span>
                <img src="<?= Knowingness\Libraries\ImageHandler::getImage($course->image, 'medium') ?>">
                <div class="details">
                    <h2><?= $course->title; ?></h2>
                    <span><?= Knowingness\Libraries\TimeHelper::convert_seconds_to_HMS(200); ?></span>
                </div>
            </a>
            <div class="block-contents">
                <p class="date"><?= date("F jS, Y", strtotime($course->created_at)); ?>
                    <span class="label label-success">$<?= $course->price ?></span>
                </p>
                <p class="desc"><?php
                    if (strlen($course->description) > 90) {
                        echo substr($course->description, 0, 90) . '...';
                    } else {
                        echo $course->description;
                    }
                    ?></p>
            </div>
        </article>
    </div>
<?php endforeach; ?>