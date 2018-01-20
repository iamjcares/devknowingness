<?php

use Knowingness\Libraries\ThemeHelper;

include('includes/header.php');
$first = '';
?>

<div id="video_title">
    <div class="container">
        <span class="label">You're viewing:</span> <h1><?= $course->title ?></h1>
    </div>
</div>

<div class="container video-details">

    <h3>
        <?= $course->title ?>
        <span class="view-count"><i class="fa fa-eye"></i> <?php if (isset($view_increment) && $view_increment == true): ?><?= $course->views + 1 ?><?php else: ?><?= $course->views ?><?php endif; ?> Views </span>
        <div class="favorite btn btn-default <?php if (isset($favorited->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-courseid="<?= $course->id ?>"><i class="fa fa-heart"></i> Favorite</div>
    </h3>

    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="panel panel-default" style="min-height: 500px;">
                <!-- Default panel contents -->
                <div class="panel-heading">Course Content</div>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <?php foreach ($chapters as $k => $chapter): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading<?= $k ?>">
                                <h4 class="panel-title">
                                    <a class="<?php echo ($k === 0 ) ? '' : 'collapsed' ?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $k ?>" aria-expanded="<?php echo ($k === 0 ) ? 'true' : 'false' ?>" aria-controls="collapse<?= $k ?>">
                                        <?= $chapter->title; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?= $k ?>" class="panel-collapse collapse <?php echo ($k === 0 ) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading<?= $k ?>">
                                <ul class="list-group">
                                    <?php foreach ($chapter->lectures as $lecture): ?>
                                        <?php
                                        if (empty($first))
                                            $first = $lecture->link;
                                        ?>
                                        <li class="list-group-item"><p>
                                                <a class="lecture" href="<?= $lecture->link; ?>" data-type="<?= $lecture->type; ?>"><span><i class="fa <?php echo ($lecture->type == 'video' ) ? 'fa-play-circle' : 'fa-link' ?>"></i></span> <?= $lecture->title; ?></a>
                                            </p></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="row">
                <div id="video_bg" >
                    <div id="video_bg_dim" class="darker"></div>
                    <div class="container-fluid">
                        <div id="video_container">
                            <video id="video_player" class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $course->image ?>" data-setup="{}" width="100%" style="width:100%;">
                                <source src="<?= $first; ?>" type='video/mp4'>
                                <!--source src="" type='video/webm' -->
                                <!--source src="" type='video/ogg' -->
                                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <br/><br/>
    <div class="container well well-large">
        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
            <li role="presentation"><a data-toggle="tab" href="#objs">Objectives</a></li>
            <li role="presentation"><a data-toggle="tab" href="#reqs">Requirements</a></li>
            <li role="presentation"><a data-toggle="tab" href="#faqs">FAQs</a></li>
        </ul>
        <div class="tab-content">
            <div id="overview" class="tab-pane fade in active">
                <h5>Details</h5>
                <div class="video-details-container"><?= $course->detail ?></div>
            </div>
            <div id="objs" class="tab-pane fade">
                <?php if (count($course->objectives) > 0): ?>
                    <div class="container">
                        <h5>What to learn?</h5>
                        <ul>
                            <?php foreach ($course->objectives as $key => $v): ?>
                                <li> <?= $v->description ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div id="reqs" class="tab-pane fade">
                <?php if (count($course->prerequisites) > 0): ?>
                    <div>
                        <h5>Prerequisites</h5>
                        <ul>
                            <?php foreach ($course->prerequisites as $key => $v): ?>
                                <li> <?= $v->description ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (count($course->requirements) > 0): ?>
                    <div>
                        <h5>Requirements</h5>
                        <ul>
                            <?php foreach ($course->requirements as $key => $v): ?>
                                <li> <?= $v->description ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div id="faqs" class="tab-pane fade">
                <?php if (count($course->faqs) > 0): ?>
                    <div>
                        <h5>FAQS</h5>
                        <ul>
                            <?php foreach ($course->faqs as $key => $v): ?>
                                <li> <?= $v->title ?>? : <?= $v->description ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <h2 id="tags">Tags:
        <?php foreach ($course->tags as $key => $tag): ?>
            <span><a href="/courses/tag/<?= $tag->name ?>"><?= $tag->name ?></a></span><?php if ($key + 1 != count($course->tags)): ?>,<?php endif; ?>
        <?php endforeach; ?>
    </h2>

    <div class="clear"></div>
    <div id="social_share">
        <p>Share This Course:</p>
        <?php include('partials/social-share.php'); ?>
    </div>

    <div class="clear"></div>

    <div id="comments">
        <div id="disqus_thread"></div>
    </div>

</div>

<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = '<?= ThemeHelper::getThemeSetting(@$theme_settings->disqus_shortname, 'hellovideo') ?>';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the comments</noscript>

<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#video_container').fitVids();
        $('.favorite').click(function () {
            if ($(this).data('authenticated')) {
                $.post('/favorite', {course_id: $(this).data('courseid'), _token: '<?= csrf_token(); ?>'}, function (data) {});
                $(this).toggleClass('active');
            } else {
                window.location = '/signup';
            }
        });
        $('.lecture').click(function (e) {
            var $type = $(this).attr('data-type');
            var $link = $(this).attr('href');
            console.log($type);
            if ($type === 'video') {
                e.preventDefault();
                var $current = videojs('video_player');
                $current.src($link);
                $current.play();
            } else {
                $(this).attr('target', '_blank');
                return true;
            }
        });
    });

</script>

<!-- RESIZING FLUID VIDEO for VIDEO JS -->
<script type="text/javascript">
    // Once the video is ready
    _V_("video_player").ready(function () {

        var myPlayer = this;    // Store the video object
        var aspectRatio = 9 / 16; // Make up an aspect ratio

        function resizeVideoJS() {
            console.log(myPlayer.id);
            // Get the parent element's actual width
            var width = document.getElementById('video_container').offsetWidth;
            // Set width to fill parent element, Set height
            myPlayer.width(width).height(width * aspectRatio);
        }

        resizeVideoJS(); // Initialize the function
        window.onresize = resizeVideoJS; // Call the function on resize
    });
</script>

<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>


<?php include('includes/footer.php'); ?>