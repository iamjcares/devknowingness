@extends('admin.master')

@section('css')
<link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')

<div id="admin-container">
    <!-- This is where -->

    <div class="admin-section-title">
        @if(!empty($course->id))
        <h3>{{ $course->title }}</h3>
        <a href="{{ URL::to('course') . '/' . $course->slug }}" target="_blank" class="btn btn-info">
            <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
        </a>
        @else
        <h3><i class="entypo-plus"></i> Add New Course</h3>
        @endif
    </div>
    <div class="clear"></div>
    <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

        <div class="row">
            <div class="@if(!empty($course->created_at)) col-sm-6 @else col-sm-8 @endif">

                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Title</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>Add the course title in the textbox below:</p>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Course Title" value="@if(!empty($course->title)){{ $course->title }}@endif" />
                    </div>
                </div>
            </div>
            <div class="@if(!empty($course->created_at)) col-sm-3 @else col-sm-4 @endif">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">SEO URL Slug</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>(example. /course/slug-name)</p>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="slug-name" value="@if(!empty($course->slug)){{ $course->slug }}@endif" />
                    </div>
                </div>
            </div>
            @if(!empty($course->created_at))
            <div class="col-sm-3">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Created Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>Select Date/Time Below</p>
                        <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($course->created_at)){{ $course->created_at }}@endif" />
                    </div>
                </div>
            </div>
            @endif
        </div>



        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Course Image Cover</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                @if(!empty($course->image))
                <img src="{{ Config::get('site.uploads_dir') . 'images/' . $course->image }}" class="video-img" width="200"/>
                @endif
                <p>Select the course image (1280x720 px or 16:9 ratio):</p>
                <input type="file" multiple="true" class="form-control" name="image" id="image" />

            </div>
        </div>

        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Course Source</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                <label for="type" style="float:left; margin-right:10px; padding-top:1px;">Course Chapters</label>
            </div>
        </div>

        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Course Details, Links, and Info</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block; padding:0px;">
                <textarea class="form-control" name="detail" id="detail">@if(!empty($course->detail)){{ htmlspecialchars($course->detail) }}@endif</textarea>
            </div>
        </div>

        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Short Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                <p>Add a short description of the course below:</p>
                <textarea class="form-control" name="description" id="description">@if(!empty($course->description)){{ htmlspecialchars($course->description) }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                        <div class="panel-title">Category</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body" style="display: block;">
                        <p>Select a Course Category Below:</p>
                        <select id="course_category_id" name="course_category_id">
                            <option value="0">Uncategorized</option>
                            @foreach($course_categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($course->course_category_id) && $course->course_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading"> <div class="panel-title"> Price</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body">
                        <p>Enter the price of the course in USD</p>
                        <input class="form-control" name="price" id="price" value="@if(!empty($course->price)){{ $course->price }}@endif">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading"> <div class="panel-title"> Status Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body">
                        <div>
                            <label for="featured" style="float:left; display:block; margin-right:10px;">Is this course Featured:</label>
                            <input type="checkbox" @if(!empty($course->featured) && $course->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                        </div>
                        <div class="clear"></div>
                        <div>
                            <label for="active" style="float:left; display:block; margin-right:10px;">Is this course Active:</label>
                            <input type="checkbox" @if(!empty($course->active) && $course->active == 1){{ 'checked="checked"' }}@elseif(!isset($course->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Tags</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                <p>Add course tags below:</p>
                <input class="form-control" name="tags" id="tags" value="@if(!empty($course) && $course->tags->count() > 0)@foreach($course->tags as $tag){{ $tag->name . ', ' }}@endforeach @endif">
            </div>
        </div>

        <div class="clear"></div>
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading"> <div class="panel-title"> Requirements</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body">
                        <p>Enter the requirement of the course</p>
                        @if(!empty($course) && $course->requirements->count() > 0)
                        @foreach($course->requirements as $req)
                        <input class="form-control" name=requirements[]" id="req-1" value="{{$req->description}}">
                        @endforeach
                        @endif
                        <input class="form-control" name="requirements[]" id="req-1" value="">
                        <input class="form-control" name="requirements[]" id="req-2" value="">
                        <input class="form-control" name="requirements[]" id="req-3" value="">
                        <input class="form-control" name="requirements[]" id="req-4" value="">
                        <input class="form-control" name="requirements[]" id="req-5" value="">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading"> <div class="panel-title"> Course Prerequisites</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body">
                        <p>Enter the prerequisites of the course</p>
                        @if(!empty($course) && $course->prerequisites->count() > 0)
                        @foreach($course->prerequisites as $pre)
                        <input class="form-control" name="prerequisites[]" id="req-1" value="{{$pre->description}}">
                        @endforeach
                        @endif

                        <input class="form-control" name="prerequisites[]" id="pre-1" value="">
                        <input class="form-control" name="prerequisites[]" id="pre-2" value="">
                        <input class="form-control" name="prerequisites[]" id="pre-3" value="">
                        <input class="form-control" name="prerequisites[]" id="pre-4" value="">
                        <input class="form-control" name="prerequisites[]" id="pre-5" value="">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading"> <div class="panel-title"> Course Objectives</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
                    <div class="panel-body">
                        <p>Enter the obejctives of the course</p>
                        @if(!empty($course) && $course->objectives->count() > 0)
                        @foreach($course->objectives as $obj)
                        <input class="form-control" name="objs[]" id="req-1" value="{{$obj->description}}">
                        @endforeach
                        @endif
                        <input class="form-control" name="objs[]" id="obj-1" value="">
                        <input class="form-control" name="objs[]" id="obj-2" value="">
                        <input class="form-control" name="objs[]" id="obj-3" value="">
                        <input class="form-control" name="objs[]" id="obj-4" value="">
                        <input class="form-control" name="objs[]" id="obj-5" value="">
                    </div>
                </div>
            </div>

        </div><!-- row -->

        @if(!isset($course->user_id))
        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
        @endif

        @if(isset($course->id))
        <input type="hidden" id="id" name="id" value="{{ $course->id }}" />
        @endif

        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
        <input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

    </form>

    <div class="clear"></div>
    <!-- This is where now -->
</div>

@section('javascript')

<script type="text/javascript" src="{{ '/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
<script type="text/javascript" src="{{ '/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
<script type="text/javascript" src="{{ '/application/assets/js/jquery.mask.min.js' }}"></script>

<script type="text/javascript">

$ = jQuery;

$(document).ready(function () {

    $('#tags').tagsInput();
    tinymce.init({
        relative_urls: false,
        selector: '#detail',
        toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
        plugins: [
            "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
            "save table contextmenu directionality emoticons template paste textcolor code"
        ],
        menubar: false,
    });

});

</script>

@stop

@stop
