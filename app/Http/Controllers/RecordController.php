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
    public function history(Request $request) : View {
        // ログインユーザー取得
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // クエリパラメータ取得
        $view = $request->query('view');

        if($view == "analytics") {
            // 収支内訳を取得（支出のみ・日時の降順）
            $categoryData = Record::with('category')->where('user_id', $user->id)
                ->where('type', 1)->orderBy('date', 'desc')->get();

            // 月ごとにグループ化・月ごとの支出合計計算
            $analyticsData = $categoryData->groupBy(function ($record) {
                // 日付から年月を取り出す（文字列のため1文字目から切り取り）
                return substr($record->date, 0, 7);
            })->map(function ($items) {
                // 月ごとの合計支出額算出
                $monthTotal = $items->sum('amount');

                // 各カテゴリーの合計額・割合(%)算出
                $categoryRatio = $items->groupBy('category_id')->map(function ($recordsOfCategory) use($monthTotal) {
                    // カテゴリー名取得（カテゴリー別配列の先頭データを取得）
                    $firstRecord = $recordsOfCategory->first();
                    // カテゴリーの合計額算出
                    $categoryTotal = $recordsOfCategory->sum('amount');

                    // 連想配列をオブジェクト型にキャスト
                    return (object)[
                        'category_name' => $firstRecord->category ? $firstRecord->category->name : '未分類',  // カテゴリー名
                        'total_amount' => $categoryTotal,  // カテゴリー合計額
                        'percentage' => $monthTotal > 0 ? round(($categoryTotal / $monthTotal) * 100) : 0  // カテゴリー金額割合（小数点以下四捨五入）
                    ];
                })->sortByDesc('total_amount');  // 金額が大きい順にソート

                // 月ごとの合計金額、カテゴリーごとの集計データ
                return ['month_total' => $monthTotal, 'categories' => $categoryRatio];
            });

            // 収支履歴のビュー、支出内訳、クエリパラメータを返す
            return view('records.history', compact('analyticsData', 'view'));
        }

        // ログインユーザーの収支データを降順に取得(カテゴリーも一緒に取得)
        $records = $user->records()->with('category')->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();

        // 年月ごとにまとめるための配列
        $historyByMonth = [];

        foreach($records as $record) {
            // 年月取得
            $monthkey = substr($record->date, 0, 7);

            // 年月のキーがない場合は配列に代入
            if(!isset($historyByMonth[$monthkey])) {
                $historyByMonth[$monthkey] = ['records' => [], 'monthTotal' => 0];
            }

            // 年月キーに収支データ追加
            $historyByMonth[$monthkey]['records'][] = $record;

            // 支出合計算出
            if($record->type == 0) {
                // 収入は加算
                $historyByMonth[$monthkey]['monthTotal'] += $record->amount;
            }
            else {
                // 支出は減算
                $historyByMonth[$monthkey]['monthTotal'] -= $record->amount;
            }
        }

        return view('records.history', compact('historyByMonth', 'view'));
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
