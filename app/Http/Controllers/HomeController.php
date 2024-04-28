<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobPostResource;
use App\Http\Resources\UserInfoResource;
use App\Models\Category;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\JobType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Response;


class HomeController extends Controller
{
    // this method will show home page
    public function index()
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();
        $featured_jobs = JobPostResource::collection(JobPost::where('status', 1)->where('is_featured', 1)->orderBy('created_at', 'DESC')->take(6)->get());
        $latest_jobs = JobPostResource::collection(JobPost::where('status', 1)->orderBy('created_at', 'DESC')->take(6)->get());
        return Inertia::render('Front/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'categories' => $categories,
            'featured_jobs' => $featured_jobs,
            'latest_jobs' => $latest_jobs,
        ]);
    }

    // this is updating the user information
    public function profile()
    {
        $user = new UserInfoResource(User::findOrFail(Auth::user()->id));
        return Inertia::render('Back/Profile', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'user' => $user
        ]);
    }

    // this method is used for changing the avatar image
    public function changeAvatar(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $avatar = $request->file('avatar');
        if ($user->image) {
            Storage::delete($user->image);
        }

        $filename = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
        $path = $avatar->storeAs('public/avatars', $filename);
        $user->image = $path;
        $user->save();

        return redirect()->back();
    }

    public function jobs(Request $request)
    {
        // Get all job types and categories
        $job_types = JobType::all();
        $categories = Category::all();

        // Query jobs
        $jobsQuery = JobPost::where('status', 1);


        // Sorting
        $sortDirection = 'DESC';
        if (request()->has('sort')) {
            $sortDirection = request()->input('sort') === '0' ? 'ASC' : 'DESC';
        }
        $jobsQuery->orderBy('created_at', $sortDirection);


        // Search using keyword
        if (!empty($request->keyword)) {
            $jobsQuery->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        // Search using location
        if (!empty($request->location)) {
            $jobsQuery->where('location', $request->location);
        }

        // Search using category
        if (!empty($request->category)) {
            $jobsQuery->where('category_id', $request->category);
        }

        // Search using job type
        if (!empty($request->job_type)) {
            // 1, 2, 3 to [1,2,3]
            $jobTypeArray = explode(',', $request->job_type);
            $jobsQuery->whereIn('job_type_id', $jobTypeArray);
        }

        // Search using experience
        if (!empty($request->experience)) {
            $jobsQuery->where('experience', ($request->experience) . ' Years');
        }


        // Paginate the results
        $jobs = JobPostResource::collection($jobsQuery->paginate(9));


        // Render the 'Front/Job' Inertia page with necessary data
        return Inertia::render('Front/Job', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'categories' => $categories,
            'job_types' => $job_types,
            'jobs' => $jobs
        ]);
    }


    public function show($slug)
    {
        $jobs = JobPostResource::collection(JobPost::where('status', 1)->where('slug', $slug)->with('JobApplication')->get());
        $users = JobApplication::where('job_post_id',$jobs[0]->id)->with('user')->get();
        foreach ($users as $user) {
            $user->applied_date = Carbon::parse($user->applied_date)->format('d M, Y');
        }
        return Inertia::render('Front/JobDetails', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'jobs' => $jobs,
            'users' => $users,
        ]);
    }

}
