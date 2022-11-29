<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $courses = Course::where('user_id', '=', Auth::user()->id)->with('produits')->get();

        return response()->json([
            'status' => 'OK',
            'courses' => $courses
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $parameters = $request->validate([
           'name' => ['required']
        ]);

        $newCourse = Course::create([
            'name' => $parameters['name'],
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'status' => 'OK',
            'course' => $newCourse
        ]);
    }

    /**
     * @param Course $course
     * @return JsonResponse
     */
    public function read(int $course): JsonResponse
    {
        $courseExist = Course::find($course);

        if (!$courseExist) {
            return response()->json([
                'status' => 'NOT OK',
                'message' => 'Aucune liste ne correspond'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'course' => $courseExist
        ]);
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return JsonResponse
     */
    public function update(Request $request, Course $course): JsonResponse
    {
        $course->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'OK',
            'course' => $course
        ]);
    }

    /**
     * @param Course $course
     * @return JsonResponse
     */
    public function delete(int $course): JsonResponse
    {
        $courseExist = Course::find($course);

        if (!$courseExist) {
            return response()->json([
                'status' => 'NOT OK',
                'message' => 'Aucune liste ne correspond'
            ]);
        }

        $courseExist->delete();

        return response()->json([
            'status' => 'OK',
        ]);
    }
}
