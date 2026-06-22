<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\RecordRequest;
use App\Models\Category;
use App\Models\Record;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class RecordController extends Controller
{
    // TOP
    public function index() : View {
        // ログインユーザーの収支データを取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $income = $user->records()->where('type', 0)->sum('amount');
        $expense = $user->records()->where('type', 1)->sum('amount');

        // 収入 - 支出
        $total = $income - $expense;
        return view('records.index', compact('total'));
    }

    // 収支登録
    public function create() : View {
        $categories = Category::forCurrentUser()->get();
        return view('records.create', compact('categories'));
    }

    // 収支履歴
    public function history() : View {
        // ログインユーザーの収支データを降順に取得(カテゴリーも一緒に取得)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $records = $user->records()->with('category')->orderBy('date', 'desc')->orderBy('created_at', 'desc')->paginate(10);

        return view('records.history', compact('records'));
    }

    // 収支詳細
    public function show(int $id) : View {
        // 表示する収支データを取得
        $record = Record::with('category')->findOrFail($id);

        // 権限チェック
        Gate::authorize('view', $record);

        // カテゴリー一覧を取得
        $categories = Category::forCurrentUser()->get();

        return view('records.show', compact('record', 'categories'));
    }

    // 収支変更
    public function edit(int $id) : View {
        // 編集したいデータIDを取得
        $record = Record::findOrFail($id);

        // 権限チェック
        Gate::authorize('view', $record);

        // カテゴリー一覧を取得
        $categories = Category::forCurrentUser()->get();

        return view('records.edit', compact('record', 'categories'));
    }

    // 収支登録処理
    public function store(RecordRequest $request) : RedirectResponse {
        $validated = $request->validated();
        $request->user()->records()->create($validated);

        Session::flash('success', '収支データを登録しました');
        return redirect(route('records.index'));
    }

    // 収支変更処理
    public function update(RecordRequest $request, int $id) : RedirectResponse {
        // 編集したいデータIDを取得
        $record = Record::findOrFail($id);

        // 権限チェック
        Gate::authorize('update', $record);

        $validated = $request->validated();
        $record->update($validated);

        Session::flash('success', '収支データを変更しました');
        return redirect(route('records.history'));
    }

    // 収支削除処理
    public function delete(int $id) : RedirectResponse {
        $record = Record::findOrFail($id);

        // 権限チェック
        Gate::authorize('delete', $record);

        $record->delete();

        Session::flash('delete', '収支データを削除しました');
        return redirect(route('records.history'));

    }
}
