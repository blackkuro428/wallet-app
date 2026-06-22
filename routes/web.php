<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('records')->name('records.')->group(function() {
    // TOP
    Route::get('', [RecordController::class, 'index'])->name('index');
    Route::get('create', [RecordController::class, 'create'])->name('create');

    // 収支履歴
    Route::get('history', [RecordController::class, 'history'])->name('history');
    // 収支詳細
    Route::get('history/{id}', [RecordController::class, 'show'])->name('show');
    // 収支変更
    Route::get('history/{id}/edit', [RecordController::class, 'edit'])->name('edit');

    // 収支登録処理
    Route::post('', [RecordController::class, 'store'])->name('store');
    // 収支変更処理
    Route::put('history/{id}', [RecordController::class, 'update'])->name('update');
    // 収支削除処理
    Route::delete('history/{id}', [RecordController::class, 'delete'])->name('delete');
});

Route::middleware('auth')->prefix('categories')->name('categories.')->group(function() {
    // カテゴリー一覧
    Route::get('',[CategoryController::class, 'index'])->name('index');

    // カテゴリー追加
    Route::get('create',[CategoryController::class, 'create'])->name('create');
    // カテゴリー編集
    Route::get('{id}/edit',[CategoryController::class, 'edit'])->name('edit');

    // カテゴリー追加処理
    Route::post('',[CategoryController::class, 'store'])->name('store');
    // カテゴリー変更処理
    Route::put('{id}',[CategoryController::class, 'update'])->name('update');
    // カテゴリー削除処理
    Route::delete('{id}',[CategoryController::class, 'delete'])->name('delete');
});


require __DIR__.'/auth.php';
