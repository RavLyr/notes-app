<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Toggle pin & archive
    Route::post('/notes/{note}/toggle-pin',     [NoteController::class, 'togglePin'])->name('notes.togglePin');
    Route::post('/notes/{note}/toggle-archive', [NoteController::class, 'toggleArchive'])->name('notes.toggleArchive');

    // Views
    Route::get('/notes/archived', [NoteController::class, 'archived'])->name('notes.archived');
    Route::get('/notes/trash',    [NoteController::class, 'trash'])->name('notes.trash');
    Route::get('/search/notes', [NoteController::class, 'search'])->name('notes.search');


    // Soft-delete actions
    Route::put('notes/{note}/restore', [NoteController::class, 'restore'])->name('notes.restore');
    Route::delete('notes/{note}/force-delete', [NoteController::class, 'forceDelete'])->name('notes.forceDelete');

    // Resource routes (index, create, store, show, edit, update, destroy)
    Route::resource('notes', NoteController::class);
});
