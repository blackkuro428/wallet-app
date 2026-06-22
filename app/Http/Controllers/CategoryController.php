<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // カテゴリー一覧
    public function index() : View {
        // カテゴリー一覧を取得(収支タイプ・カテゴリーIDの昇順)
        $categories = Category::forCurrentUser()->orderBy('type')->orderBy('id')->get();

        return view('categories.index', compact('categories'));
    }

    // カテゴリー追加
    public function create() : View {
        return view('categories.create');
    }

    // カテゴリー編集
    public function edit(int $id) : View {
        // 編集するカテゴリーデータを取得
        $category = Category::findOrfail($id);

        // 権限チェック
        Gate::authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    // カテゴリー登録処理
    public function store(CategoryRequest $request) : RedirectResponse {
        $validated = $request->validated();
        $request->user()->categories()->create($validated);

        Session::flash('success', 'カテゴリーを追加しました');
        return redirect(route('categories.index'));
    }

    // カテゴリー編集処理
    public function update(CategoryRequest $request, int $id) : RedirectResponse {
        // 編集するカテゴリーデータを取得
        $category = Category::findOrfail($id);

        // 権限チェック
        Gate::authorize('update', $category);

        $validated = $request->validated();
        $category->update($validated);

        Session::flash('success', 'カテゴリーを編集しました');
        return redirect(route('categories.index'));
    }

    // カテゴリー削除処理
    public function delete(int $id) : RedirectResponse {
        // 削除するカテゴリーデータを取得
        $category = Category::findOrfail($id);

        // 権限チェック
        Gate::authorize('delete', $category);

        $category->delete();

        Session::flash('delete', 'カテゴリーを削除しました');
        return redirect(route('categories.index'));
    }
}
