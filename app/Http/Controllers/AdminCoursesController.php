<?php

use \Redirect as Redirect;

class AdminCoursesController extends \BaseController
{

    /**
     * Display a listing of courses
     *
     * @return Response
     */
    public function index()
    {

        $search_value = Input::get('s');

        if (!empty($search_value)):
            $courses = Course::where('title', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $courses = Course::orderBy('created_at', 'DESC')->paginate(9);
        endif;

        $user = Auth::user();

        $data = array(
            'courses' => $courses,
            'user' => $user,
            'admin_user' => Auth::user()
        );

        return View::make('admin.courses.index', $data);
    }

    /**
     * Show the form for creating a new course
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Video',
            'post_route' => URL::to('admin/courses/store'),
            'button_text' => 'Add New Video',
            'admin_user' => Auth::user(),
            'course_categories' => VideoCategory::all(),
        );
        return View::make('admin.courses.create_edit', $data);
    }

    /**
     * Store a newly created course in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Video::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $image = $data['image'];
        if (!empty($image)) {
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        } else {
            $data['image'] = 'placeholder.jpg';
        }

        $tags = $data['tags'];
        unset($data['tags']);

        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['featured'])) {
            $data['featured'] = 0;
        }

        if (isset($data['duration'])) {
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['duration'] = $time_seconds;
        }

        $course = Video::create($data);
        $this->addUpdateVideoTags($course, $tags);

        return Redirect::to('admin/courses')->with(array('note' => 'New Video Successfully Added!', 'note_type' => 'success'));
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $course = Video::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'course' => $course,
            'post_route' => URL::to('admin/courses/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'course_categories' => VideoCategory::all(),
        );

        return View::make('admin.courses.create_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $input = Input::all();
        $id = $input['id'];
        $course = Video::findOrFail($id);

        $validator = Validator::make($data = $input, Video::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $tags = $data['tags'];
        unset($data['tags']);
        $this->addUpdateVideoTags($course, $tags);

        if (isset($data['duration'])) {
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['duration'] = $time_seconds;
        }

        if (empty($data['image'])) {
            unset($data['image']);
        } else {
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        }

        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['featured'])) {
            $data['featured'] = 0;
        }

        $course->update($data);

        return Redirect::to('admin/courses/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Video!', 'note_type' => 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $course = Video::find($id);

        // Detach and delete any unused tags
        foreach ($course->tags as $tag) {
            $this->detachTagFromVideo($course, $tag->id);
            if (!$this->isTagContainedInAnyVideos($tag->name)) {
                $tag->delete();
            }
        }

        $this->deleteVideoImages($course);

        Video::destroy($id);

        return Redirect::to('admin/courses')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success'));
    }

    private function addUpdateVideoTags($course, $tags)
    {
        $tags = array_map('trim', explode(',', $tags));


        foreach ($tags as $tag) {

            $tag_id = $this->addTag($tag);
            $this->attachTagToVideo($course, $tag_id);
        }

        // Remove any tags that were removed from course
        foreach ($course->tags as $tag) {
            if (!in_array($tag->name, $tags)) {
                $this->detachTagFromVideo($course, $tag->id);
                if (!$this->isTagContainedInAnyVideos($tag->name)) {
                    $tag->delete();
                }
            }
        }
    }

    /*     * ************************************************
      /*
      /*  PRIVATE FUNCTION
      /*  addTag( tag_name )
      /*
      /*  ADD NEW TAG if Tag does not exist
      /*  returns tag id
      /*
      /************************************************* */

    private function addTag($tag)
    {
        $tag_exists = Tag::where('name', '=', $tag)->first();

        if ($tag_exists) {
            return $tag_exists->id;
        } else {
            $new_tag = new Tag;
            $new_tag->name = strtolower($tag);
            $new_tag->save();
            return $new_tag->id;
        }
    }

    /*     * ************************************************
      /*
      /*  PRIVATE FUNCTION
      /*  attachTagToVideo( course object, tag id )
      /*
      /*  Attach a Tag to a Video
      /*
      /************************************************* */

    private function attachTagToVideo($course, $tag_id)
    {
        // Add New Tags to course
        if (!$course->tags->contains($tag_id)) {
            $course->tags()->attach($tag_id);
        }
    }

    private function detachTagFromVideo($course, $tag_id)
    {
        // Detach the pivot table
        $course->tags()->detach($tag_id);
    }

    public function isTagContainedInAnyVideos($tag_name)
    {
        // Check if a tag is associated with any courses
        $tag = Tag::where('name', '=', $tag_name)->first();
        return (!empty($tag) && $tag->courses->count() > 0) ? true : false;
    }

    private function deleteVideoImages($course)
    {
        $ext = pathinfo($course->image, PATHINFO_EXTENSION);

        if (file_exists('.' . Config::get('site.uploads_dir') . 'images/' . $course->image) && $course->image != 'placeholder.jpg') {
            @unlink('.' . Config::get('site.uploads_dir') . 'images/' . $course->image);
        }

        if (file_exists('.' . Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $course->image)) && $course->image != 'placeholder.jpg') {
            @unlink('.' . Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $course->image));
        }

        if (file_exists('.' . Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $course->image)) && $course->image != 'placeholder.jpg') {
            @unlink('.' . Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $course->image));
        }

        if (file_exists('.' . Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $course->image)) && $course->image != 'placeholder.jpg') {
            @unlink('.' . Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $course->image));
        }
    }

}
