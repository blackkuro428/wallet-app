<div class="mb-5 text-left">
    <label class="block text-xl mb-2">収支チェック</label>
    <div class="flex items-center gap-4 pointer-events-none">
        <label class="flex items-center cursor-pointer px-2 py-1 text-lg rounded-md transition-colors bg-[#A8E2FF]">
            <input type="radio" name="type" value="0" class="w-4 h-4 text-blue-600 border-gray-300"
                {{ old('type', $record->type ?? '1') == '0' ? 'checked' : '' }}>
            <span class="ml-2 text-gray-700 px-3 py-1 rounded text-lg">収入</span>
        </label>
        <label class="flex items-center cursor-pointer px-2 py-1 text-lg rounded-md transition-colors bg-[#FFAEAE]">
            <input type="radio" name="type" value="1" class="w-4 h-4 text-red-600 border-gray-300 "
                {{ old('type', $record->type ?? '1') == '1' ? 'checked' : '' }}>
            <span class="ml-2 text-gray-700 px-3 py-1 rounded text-lg">支出</span>
        </label>
    </div>
</div>

<div class="mb-5 text-left">
    <label for="date" class="block text-xl mb-2">日付</label>
    <input type="date" id="date" name="date"
        value="{{ old('date', $record->date ?? date('Y-m-d')) }}"
        class="w-full max-w-[200px] rounded-md border-gray-300 shadow-sm text-gray-500 bg-gray-50 pointer-events-none" disabled>
</div>

<div class="mb-5 text-left">
    <label for="amount" class="block text-xl mb-2">金額</label>
    <input type="number" id="amount" name="amount" placeholder="1000"
        value="{{ old('amount', $record->amount ?? '') }}"
        class="w-full max-w-[200px] rounded-md border-gray-300 shadow-sm text-gray-500 bg-gray-50 pointer-events-none" disabled>
</div>

<div class="mb-5 text-left">
    <label for="category_id" class="block text-xl mb-2">カテゴリー</label>
    <select id="category_id" name="category_id"
        class="w-full max-w-[200px] rounded-md border-gray-300 shadow-sm pointer-events-none" disabled>
        <option value="">選択してください</option>
        @foreach($categories as $category)
        <option value="{{$category->id}}" data-type="{{$category->type}}" {{ old('category_id', $record->category_id ?? '') == $category->id ? 'selected' : '' }}>
            {{$category->name}}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-6 text-left">
    <label for="memo" class="block text-xl mb-2">メモ</label>
    <textarea id="memo" name="memo" rows="10" class="w-full max-w-[400px] rounded-md border-gray-300 shadow-sm text-gray-500 bg-gray-50 pointer-events-none" disabled>{{ old('memo', $record->memo ?? '') }}</textarea>
</div>
