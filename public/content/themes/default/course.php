<?php

use Knowingness\Libraries\ThemeHelper;

include('includes/header.php');
?>

<div id="video_title">
    <div class="container">
        <span class="label">You're viewing:</span> <h1><?= $course->title ?></h1>
    </div>
</div>
<div id="video_bg" style="background-image:url(<?= Config::get('site.uploads_url') . '/images/' . str_replace(' ', '%20', $course->image) ?>)">
    <div id="video_bg_dim" class="darker"></div>
    <div class="container">
        <div id="video_container" class="fitvid">
            <iframe width="560" height="315" src="//www.youtube.com/embed/nYzoQVea1NI" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>


<div class="container video-details">

    <h3>
        <?= $course->title ?>
        <span class="view-count"><i class="fa fa-eye"></i> <?php if (isset($view_increment) && $view_increment == true): ?><?= $course->views + 1 ?><?php else: ?><?= $course->views ?><?php endif; ?> Views </span>
        <div class="favorite btn btn-default <?php if (isset($favorited->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-courseid="<?= $course->id ?>"><i class="fa fa-heart"></i> Favorite</div>
        <div class="cart btn btn-default" data-authenticated="<?= !Auth::guest() ?>" data-courseid="<?= $course->id ?>"><i class="fa fa-cart-plus"></i> Add to Cart</div>
    </h3>
    <div class="video-details-container"><?= $course->detail ?></div>


    <?php if (count($course->objectives) > 0): ?>
        <div class="container">
            <h3>What to learn?</h3>
            <ul>
                <?php foreach ($course->objectives as $key => $v): ?>
                    <li> <?= $v->description ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (count($course->requirements) > 0): ?>
        <div>
            <h3>Requirements</h3>
            <ul>
                <?php foreach ($course->requirements as $key => $v): ?>
                    <li> <?= $v->description ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    <?php endif; ?>
    <?php if (count($course->prerequisites) > 0): ?>
        <div>
            <h3>Prerequisites</h3>
            <ul>
                <?php foreach ($course->prerequisites as $key => $v): ?>
                    <li> <?= $v->description ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    <?php endif; ?>

    <div class="row">
        <h3>Curriculum</h3>
        <?php include('partials/chapter-loop.php'); ?>
    </div>

    <?php if (count($course->faqs) > 0): ?>
        <div>
            <h3>FAQS</h3>
            <ul>
                <?php foreach ($course->faqs as $key => $v): ?>
                    <li> <?= $v->title ?>? : <?= $v->description ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    <?php endif; ?>

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
        $('.cart').click(function () {
            if ($(this).data('authenticated')) {
                $.post('/cart/add', {course_id: $(this).data('courseid'), _token: '<?= csrf_token(); ?>'}, function (data) {
                    window.location = '/courses';
                });
            } else {
                window.location = '/signup';
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