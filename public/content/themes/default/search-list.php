<?php include('includes/header.php'); ?>

<div class="container search-results">

    <?php if (count($courses) < 1): ?>
        <h4>No Course Search results found for <?= $search_value ?></h4>
    <?php else: ?>
        <h3>Course Search Results <span>for <?= $search_value ?></span></h3>

        <div class="row">

            <?php include('partials/course-loop.php'); ?>

        </div>

    <?php endif; ?>

    <?php if (count($posts) < 1): ?>
        <h4>No Post Search results found for <?= $search_value ?></h4>
    <?php else: ?>
        <h3>Post Search Results <span>for <?= $search_value ?></span></h3>

        <div class="row">

            <?php include('partials/post-loop.php'); ?>

        </div>
    <?php endif; ?>

</div>



<?php include('includes/footer.php'); ?>