@extends('admin.master')

@section('css')
<link rel="stylesheet" href="{{ '/application/assets/admin/css/sweetalert.css' }}">
@endsection

@section('content')

<div class="admin-section-title">
    <div class="row">
        <div class="col-md-8">
            <h3><i class="entypo-video"></i> Courses</h3><a href="{{ URL::to('admin/courses/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
        <div class="col-md-4">
            <form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= Input::get('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="gallery-env">

    <div class="row">

        @foreach($courses as $course)

        <div class="col-sm-6 col-md-4">

            <article class="album">

                <header>

                    <a href="{{ URL::to('course/') . '/' . $course->slug }}" target="_blank">
                        <img src="{{ Config::get('site.uploads_dir') . 'images/' . $course->image }}" />
                    </a>

                    <a href="{{ URL::to('admin/courses/edit') . '/' . $course->id }}" class="album-options">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                </header>

                <section class="album-info">
                    <h3><a href="{{ URL::to('admin/courses/edit') . '/' . $course->id }}"><?php
                            if (strlen($course->title) > 25) {
                                echo substr($course->title, 0, 25) . '...';
                            } else {
                                echo $course->title;
                            }
                            ?></a></h3>

                    <p>{{ $course->description }}</p>
                </section>

                <footer>

                    <div class="album-images-count">
                        <i class="entypo-video"></i>
                    </div>

                    <div class="album-options">
                        <a href="{{ URL::to('admin/courses/edit') . '/' . $course->id }}">
                            <i class="entypo-pencil"></i>
                        </a>

                        <a href="{{ URL::to('admin/courses/delete') . '/' . $course->id }}" class="delete">
                            <i class="entypo-trash"></i>
                        </a>
                    </div>

                </footer>

            </article>

        </div>

        @endforeach

        <div class="clear"></div>

        <div class="pagination-outter"><?= $courses->appends(Request::only('s'))->render(); ?></div>

    </div>

</div>


@section('javascript')
<script src="{{ '/application/assets/admin/js/sweetalert.min.js' }}"></script>
<script>

$(document).ready(function () {
    var delete_link = '';

    $('.delete').click(function (e) {
        e.preventDefault();
        delete_link = $(this).attr('href');
        swal({title: "Are you sure?", text: "Do you want to permanantly delete this course?", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!", closeOnConfirm: false}, function () {
            window.location = delete_link
        });
        return false;
    });
});

</script>

@stop

@stop