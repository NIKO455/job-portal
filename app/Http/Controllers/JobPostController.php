<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostRequest;
use App\Http\Requests\JobPostUpdateRequest;
use App\Http\Resources\JobPostResource;
use App\Http\Resources\UserInfoResource;
use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Mockery\Exception;
use Illuminate\Support\Str;
use function Pest\Laravel\json;

class JobPostController extends Controller
{
    public function index(): \Inertia\Response
    {
        $user = new UserInfoResource(User::findOrFail(Auth::user()->id));
        $job_posts = JobPostResource::collection(JobPost::where('user_id', Auth::user()->id)->with(['user', 'category', 'jobType','JobApplication'])->orderBy('created_at', 'DESC')->paginate(10));
        return Inertia::render('Back/JobPost/Index', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'user' => $user,
            'job_posts' => $job_posts,
        ]);
    }

    public function create(): \Inertia\Response
    {
        $job_types = JobType::all();
        $categories = Category::all();
        $user = new UserInfoResource(User::findOrFail(Auth::user()->id));
        return Inertia::render('Back/JobPost/Create', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'user' => $user,
            'job_types' => $job_types,
            'categories' => $categories,
        ]);
    }

    public function store(JobPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['title']);
            $data['user_id'] = Auth::user()->id;
            JobPost::create($data);
        } catch (Exception $exception) {
            dd($exception);
        }
        return redirect()->route('job.index');
    }

    public function edit($id)
    {
        try {
            $post = JobPost::findOrFail($id);
            $job_types = JobType::all();
            $categories = Category::all();

            $user = new UserInfoResource(User::findOrFail(Auth::user()->id));

            return Inertia::render('Back/JobPost/Edit', [
                'user' => $user,
                'post' => $post,
                'job_types' => $job_types,
                'categories' => $categories,
            ]);
        } catch (Exception $exception) {
            dd($exception);
        }
    }

    public function update(JobPostUpdateRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['title']);
            $data['user_id'] = Auth::user()->id;
            $post = JobPost::findOrFail($id);
            $post->update($data);
        } catch (Exception $exception) {
            dd($exception);
        }
        return redirect()->route('job.index');
    }

    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        try {
            $post = JobPost::findOrFail($id);
            $post->delete();
        } catch (Exception $exception) {
            dd($exception);
        }
        return redirect()->route('job.index');
    }

    public function jobApplyIndex(): \Inertia\Response
    {
        $user = new UserInfoResource(User::findOrFail(Auth::id()));
        $jobIds = JobApplication::where('user_id', Auth::id())->pluck('job_post_id');
        $job_posts = JobPostResource::collection(JobPost::whereIn('id', $jobIds)->with(['user', 'category', 'jobType', 'JobApplication'])->orderBy('created_at', 'DESC')->paginate(10));
        return Inertia::render('Back/JobPost/JobApplied', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'user' => $user,
            'job_posts' => $job_posts,
        ]);
    }

    public function jobApply($id): \Illuminate\Http\RedirectResponse
    {
        $check = JobApplication::where('user_id', Auth::id())->where('job_post_id', $id)->first();
        if ($check) {
            return redirect()->back();
        }

        $job = JobPost::where('status', 1)->where('id', $id)->with('user')->get();
        if ($job) {
            JobApplication::create([
                'job_post_id' => $id,
                'user_id' => Auth::id(),
                'applied_date' => Date::now()
            ]);
        }

        $mailData = [
            'created_by' => $job[0]->user,
            'user' => Auth::user(),
            'job' => $job[0],
        ];

        Mail::to($job[0]->user->email)->send(new JobNotificationEmail($mailData));

        return redirect()->back();
    }

    public function jobApplyDelete($id): \Illuminate\Http\RedirectResponse
    {
        $job = JobApplication::where('job_post_id',$id)->where('user_id',Auth::id())->first();
        $job->delete();
        return redirect()->back();
    }

    public function jobSaveIndex(): \Inertia\Response
    {
        $user = new UserInfoResource(User::findOrFail(Auth::id()));
        $jobIds = SavedJob::where('user_id', Auth::id())->pluck('job_post_id');
        $job_posts = JobPostResource::collection(JobPost::whereIn('id', $jobIds)->with(['user', 'category', 'jobType', 'JobApplication'])->orderBy('created_at', 'DESC')->paginate(10));
        return Inertia::render('Back/JobPost/JobSaved', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'user' => $user,
            'job_posts' => $job_posts,
        ]);
    }

    public function jobSave($id): \Illuminate\Http\RedirectResponse
    {
        $check = SavedJob::where('user_id', Auth::id())->where('job_post_id', $id)->first();

        if ($check) {
            return redirect()->back();
        }

        $job = JobPost::where('status', 1)->where('id', $id)->with('user')->get();
        if ($job) {
            SavedJob::create([
                'job_post_id' => $id,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->back();
    }

    public function jobSaveDelete($id): \Illuminate\Http\RedirectResponse
    {
        $job = SavedJob::where('job_post_id',$id)->where('user_id',Auth::id())->first();
        $job->delete();
        return redirect()->back();
    }
}
