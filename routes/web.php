<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/jobs', 'jobs')->name('jobs');
    Route::get('/job/{slug}', 'show')->name('show.job');
});

Route::get('/go-back', function () {
    return redirect()->back();
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/profile/account', 'profile')->name('profile');
        Route::post('/profile/avatar/{id}', 'changeAvatar')->name('profile.avatar');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::controller(JobPostController::class)->group(function () {
        Route::get('/my_job', 'index')->name('job.index');
        Route::get('/create/job', 'create')->name('job.create');
        Route::post('/create/job', 'store')->name('job.store');
        Route::get('/edit/job/{id}', 'edit')->name('job.edit');
        Route::post('/update/job/{id}', 'update')->name('job.update');
        Route::delete('/delete/job/{id}', 'delete')->name('job.delete');

        Route::get('/applied/jobs', 'jobApplyIndex')->name('job.apply.index');
        Route::post('/job-apply/{id}','jobApply')->name('job.apply');
        Route::delete('/job-apply/delete/{id}','jobApplyDelete')->name('job.apply.delete');

        Route::get('/save/jobs', 'jobSaveIndex')->name('job.save.index');
        Route::post('/save-job/{id}','jobSave')->name('job.save');
        Route::delete('/job-save/delete/{id}','jobSaveDelete')->name('job.save.delete');

    });

});


require __DIR__ . '/auth.php';
