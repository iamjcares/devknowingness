<?php include('includes/header.php'); ?>

<div class="container">
    <?php if (isset($page_title)): ?>
        <h2><?= $page_title ?></h2>
    <?php endif; ?>
    <div class="row">
        <table class="table table-responsive table-hover">
            <?php if (count($courses) > 0): ?>
                <tr class="table-header">
                    <th>Course</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($courses as $course): $subtotal += $course->price; ?>
                    <tr>
                        <td><?= $course->title; ?></td>
                        <td><?= $course->price; ?></td>
                        <td>
                            <a href="#" data-authenticated="<?= !Auth::guest() ?>"  data-courseid="<?= $course->id ?>" class="btn btn-xs btn-danger remove"><span class="fa fa-trash"></span> Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Subtotal</td>
                    <td><?= $subtotal; ?></td>
                    <td><a href="/checkout" class="btn btn-xs btn-success checkout"><span class="fa fa-cart-plus"></span>Checkout</a></td>
                </tr>
            <?php else: ?>
                <tr class="table-header">
                    <th>Your Cart is Empty</th>
                </tr>
            <?php endif; ?>
        </table>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('.remove').click(function (e) {
            e.preventDefault();
            if ($(this).data('authenticated')) {
                $.post('/cart/remove', {course_id: $(this).data('courseid'), _token: '<?= csrf_token(); ?>'}, function (data) {
                    window.location = '/cart';
                });
            } else {
                window.location = '/signup';
            }
        });
    });

</script>

<?php include('includes/footer.php'); ?>