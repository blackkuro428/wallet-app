<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:0,1',
            'date' => 'required|date',
            'amount' => 'required|integer|min:1',
            'category_id' =>  'required|exists:categories,id',
            'memo' => 'nullable|string|max:500',
        ];
    }

    /* エラーメッセージカスタム */
    public function messages(): array {
        return [
            'required'=>':attribute は必須項目です',
            'date'=>':attribute は正しい日付形式で入力してください',
            'integer'=>':attribute は整数で入力してください',
            'in'=>'不正な :attribute が選択されました',
            'exsists'=>'選択された :attribute は登録されていません',
            'max'=>':attribute は :max 文字以内で入力してください',
            'amount.min'=>'金額は1円以上で入力してください',
        ];
    }

    /* attribute定義 */
    public function attributes(): array {
        return [
            'type'=>'収支タイプ',
            'date'=>'日付',
            'amount'=>'金額',
            'category_id'=>'カテゴリー',
            'memo'=>'メモ',
        ];
    }
}
