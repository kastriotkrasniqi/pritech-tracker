<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueTagController;
use App\Http\Controllers\IssueUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('projects.index'))->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);
    Route::resource('projects.issues', IssueController::class)->shallow();
    Route::resource('tags', TagController::class)->only(['index', 'store', 'destroy']);

    // Tag attach/detach (AJAX)
    Route::post('issues/{issue}/tags/{tag}', [IssueTagController::class, 'attach'])->name('issues.tags.attach');
    Route::delete('issues/{issue}/tags/{tag}', [IssueTagController::class, 'detach'])->name('issues.tags.detach');

    // Comments (AJAX)
    Route::get('issues/{issue}/comments', [CommentController::class, 'index'])->name('issues.comments.index');
    Route::post('issues/{issue}/comments', [CommentController::class, 'store'])->name('issues.comments.store');

    // User assignment (AJAX bonus)
    Route::post('issues/{issue}/users/{user}', [IssueUserController::class, 'attach'])->name('issues.users.attach');
    Route::delete('issues/{issue}/users/{user}', [IssueUserController::class, 'detach'])->name('issues.users.detach');
});

require __DIR__.'/auth.php';
