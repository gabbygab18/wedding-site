<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AdminController;

// ─── Public Invitation ────────────────────────
Route::get('/', [InvitationController::class, 'show'])->name('invitation');
Route::post('/rsvp', [InvitationController::class, 'storeRsvp'])->name('rsvp.store');

// ─── Auth ─────────────────────────────────────
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login')->middleware('guest');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
})->name('login.post')->middleware('guest');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/admin/login');
})->name('logout');

// ─── Admin Panel ──────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Wedding details
    Route::get('/wedding',    [AdminController::class, 'editWedding'])->name('wedding.edit');
    Route::put('/wedding',    [AdminController::class, 'updateWedding'])->name('wedding.update');

    // Photos
    Route::get('/photos',              [AdminController::class, 'photosIndex'])->name('photos.index');
    Route::post('/photos',             [AdminController::class, 'storePhotos'])->name('photos.store');
    Route::delete('/photos/{photo}',   [AdminController::class, 'destroyPhoto'])->name('photos.destroy');
    Route::patch('/photos/{photo}/order', [AdminController::class, 'updatePhotoOrder'])->name('photos.order');

    // Entourage
    Route::get('/entourage',               [AdminController::class, 'entourageIndex'])->name('entourage.index');
    Route::post('/entourage',              [AdminController::class, 'storeEntourage'])->name('entourage.store');
    Route::delete('/entourage/{member}',   [AdminController::class, 'destroyEntourage'])->name('entourage.destroy');

    // RSVPs
    Route::get('/rsvp',            [AdminController::class, 'rsvpIndex'])->name('rsvp.index');
    Route::delete('/rsvp/{rsvp}',  [AdminController::class, 'destroyRsvp'])->name('rsvp.destroy');
    Route::get('/rsvp/export',     [AdminController::class, 'exportRsvp'])->name('rsvp.export');
});
