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
            'headline' => '<i class="fa fa-plus-circle"></i> New Course',
            'post_route' => URL::to('admin/courses/store'),
            'button_text' => 'Add New Course',
            'admin_user' => Auth::user(),
            'course_categories' => CourseCategory::all(),
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
        $validator = Validator::make($data = Input::all(), Course::$rules);

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

        $reqs = $data['requirements'];
        unset($data['requirements']);

        $pres = $data['prerequisites'];
        unset($data['prerequisites']);

        $objs = $data['objs'];
        unset($data['objs']);

        if (empty($data['active'])) {
            $data['active'] = 0;
        }

        if (empty($data['featured'])) {
            $data['featured'] = 0;
        }

        $course = Course::create($data);
        $this->addUpdateCourseTags($course, $tags);
        $this->addUpdateCourseRequirements($course, $reqs);
        $this->addUpdateCoursePrerequisites($course, $pres);
        $this->addUpdateCourseObjectives($course, $objs);


        return Redirect::to('admin/courses')->with(array('note' => 'New Course Successfully Added!', 'note_type' => 'success'));
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $course = Course::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Course',
            'course' => $course,
            'post_route' => URL::to('admin/courses/update'),
            'button_text' => 'Update Course',
            'admin_user' => Auth::user(),
            'course_categories' => CourseCategory::all(),
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
        $course = Course::findOrFail($id);

        $validator = Validator::make($data = $input, Course::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // updating the tags
        $tags = $data['tags'];
        unset($data['tags']);
        $this->addUpdateCourseTags($course, $tags);

        // updating the objectives
        $objs = $data['objs'];
        unset($data['objs']);
        $this->addUpdateCourseObjectives($course, $objs);

        // updating the requirements
        $reqs = $data['requirements'];
        unset($data['requirements']);
        $this->addUpdateCourseRequirements($course, $reqs);

        // updating the prerequisites
        $objs = $data['prerequisites'];
        unset($data['prerequisites']);
        $this->addUpdateCoursePrerequisites($course, $objs);

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
        return Redirect::to('admin/courses/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Course!', 'note_type' => 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        // Detach and delete any unused tags
        foreach ($course->tags as $tag) {
            $this->detachTagFromCourse($course, $tag->id);
            if (!$this->isTagContainedInAnyCourses($tag->name)) {
                $tag->delete();
            }
        }
        foreach ($course->requirements as $req) {
            $req->delete();
        }
        foreach ($course->objectives as $obj) {
            $obj->delete();
        }
        foreach ($course->prerequisites as $pre) {
            $pre->delete();
        }

        $this->deleteCourseImages($course);

        Course::destroy($id);

        return Redirect::to('admin/courses')->with(array('note' => 'Successfully Deleted Course', 'note_type' => 'success'));
    }

    private function addUpdateCourseTags($course, $tags)
    {
        $tags = array_map('trim', explode(',', $tags));

        foreach ($tags as $tag) {

            $tag_id = $this->addTag($tag);
            $this->attachTagToCourse($course, $tag_id);
        }

        // Remove any tags that were removed from course
        foreach ($course->tags as $tag) {
            if (!in_array($tag->name, $tags)) {
                $this->detachTagFromCourse($course, $tag->id);
                if (!$this->isTagContainedInAnyCourses($tag->name)) {
                    $tag->delete();
                }
            }
        }
    }

    private function addUpdateCourseObjectives($course, $objectives)
    {
        foreach ($objectives as $obj) {
            if (!empty($obj)) {
                $this->addObjective($obj, $course->id);
            }
        }

        foreach ($course->objectives as $obj) {
            if (!in_array($obj->description, $objectives)) {
                $obj->delete();
            }
        }
    }

    private function addUpdateCourseRequirements($course, $reqs)
    {
        foreach ($reqs as $req) {
            if (!empty($req)) {
                $this->addRequirement($req, $course->id);
            }
        }

        foreach ($course->requirements as $req) {
            if (!in_array($req->description, $reqs)) {
                $req->delete();
            }
        }
    }

    private function addUpdateCoursePrerequisites($course, $pres)
    {
        foreach ($pres as $pre) {
            if (!empty($pre)) {
                $this->addPrerequisite($pre, $course->id);
            }
        }

        foreach ($course->prerequisites as $pre) {
            if (!in_array($pre->description, $pres)) {
                $pre->delete();
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

    /**
     *
     * @param type $objective
     * @return objective id
     */
    private function addObjective($objective, $cid)
    {
        $obj_exists = Objective::where('description', $objective)->where('course_id', $cid)->first();

        if ($obj_exists) {
            return $obj_exists->id;
        } else {
            $new_obj = new Objective();
            $new_obj->description = $objective;
            $new_obj->course_id = $cid;
            $new_obj->save();
            return $new_obj->id;
        }
    }

    private function addRequirement($requirement, $cid)
    {
        $req_exists = Requirement::where('description', $requirement)->where('course_id', $cid)->first();

        if ($req_exists) {
            return $req_exists->id;
        } else {
            $new_req = new Requirement();
            $new_req->description = $requirement;
            $new_req->course_id = $cid;
            $new_req->save();
            return $new_req->id;
        }
    }

    private function addPrerequisite($prerequisite, $cid)
    {
        $obj_exists = Prerequisite::where('description', $prerequisite)->where('course_id', $cid)->first();

        if ($obj_exists) {
            return $obj_exists->id;
        } else {
            $new_obj = new Prerequisite();
            $new_obj->description = $prerequisite;
            $new_obj->course_id = $cid;
            $new_obj->save();
            return $new_obj->id;
        }
    }

    /*     * ************************************************
      /*
      /*  PRIVATE FUNCTION
      /*  attachTagToCourse( course object, tag id )
      /*
      /*  Attach a Tag to a Course
      /*
      /************************************************* */

    private function attachTagToCourse($course, $tag_id)
    {
        // Add New Tags to course
        if (!$course->tags->contains($tag_id)) {
            $course->tags()->attach($tag_id);
        }
    }

    private function detachTagFromCourse($course, $tag_id)
    {
        // Detach the pivot table
        $course->tags()->detach($tag_id);
    }

    public function isTagContainedInAnyCourses($tag_name)
    {
        // Check if a tag is associated with any courses
        $tag = Tag::where('name', '=', $tag_name)->first();
        return (!empty($tag) && $tag->courses->count() > 0) ? true : false;
    }

    private function deleteCourseImages($course)
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
