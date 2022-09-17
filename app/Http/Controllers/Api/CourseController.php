<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
  //course entollment api -post
  public function courseEnrollment(Request $request)
  {
    // validation
    $request->validate([
      "title" => "required",
      "description" => "required",
      "total_videos" => "required"
    ]);

    //create course object
    $course = new Course();

    $course->user_id = auth()->user()->id;
    $course->title = $request->title;
    $course->description = $request->description;
    $course->total_videos = $request->total_videos;

    $course->save();

    //send response
    return response()->json([
      "status" => 1,
      "message" => "Course enrolled successfully"

    ]);
  }

  // Total course enrollment - get
  public function totalCourses()
  {
    $id = auth()->user()->id;
    $courses = User::find($id)->courses;

    return response()->json([
      "status" => 1,
      "message" => "Total Courses enrolled successfully",
      "data" => $courses
    ]);
  }

  // Delete course API - DELETe
  public function deleteCourse($id)
  {
    //user id 
    //course id
    //course table delete

    $user_id = auth()->user()->id;

    if (Course::where([
      "id" => $id,
      "user_id" => $user_id,
    ])->exists()) {
      $course = Course::find($id);

      $course->delete();
      return response()->json([
        "status" => 1,
        "message" => "Course deleted"
      ]);
    } else {

      return response()->json([
        "status" => 0,
        "message" => "course not found"
      ]);
    }
  }
}
