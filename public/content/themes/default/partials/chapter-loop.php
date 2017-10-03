<?php foreach ($chapters as $chapter): ?>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <article class="block">
            <h4><?= $chapter->title; ?></h4>
            <p class="desc"> <?= $chapter->description; ?></p>
            <ul>
                <?php foreach ($chapter->lectures as $lecture): ?>
                    <li><h5><?= $lecture->title; ?> (<?= $lecture->type; ?>)</h5></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </div>
<?php endforeach; ?>