<div class="mb-5 text-left">
    <label class="block text-xl mb-2">収支チェック</label>
    <div class="flex items-center gap-4">
        <label class="flex items-center cursor-pointer px-2 py-1 text-lg rounded-md transition-colors bg-[#A8E2FF]">
            <input type="radio" name="type" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                {{ old('type', $record->type ?? '1') == '0' ? 'checked' : '' }}>
            <span class="ml-2 text-gray-700 px-3 py-1 rounded text-lg">収入</span>
        </label>
        <label class="flex items-center cursor-pointer px-2 py-1 text-lg rounded-md transition-colors bg-[#FFAEAE]">
            <input type="radio" name="type" value="1" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                {{ old('type', $record->type ?? '1') == '1' ? 'checked' : '' }}>
            <span class="ml-2 text-gray-700 px-3 py-1 rounded text-lg">支出</span>
        </label>
    </div>

    @error('type')
    <p class="text-red-600 text-sm mt-1">{{$message}}</p>
    @enderror
</div>

<div class="mb-5 text-left">
    <label for="date" class="block text-xl mb-2">日付</label>
    <input type="date" id="date" name="date"
        value="{{ old('date', $record->date ?? date('Y-m-d')) }}"
        class="w-full max-w-[200px] rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

    @error('date')
    <p class="text-red-600 text-sm mt-1">{{$message}}</p>
    @enderror
</div>

<div class="mb-5 text-left">
    <label for="amount" class="block text-xl mb-2">金額</label>
    <input type="number" id="amount" name="amount" placeholder="1000"
        value="{{ old('amount', $record->amount ?? '') }}"
        class="w-full max-w-[200px] rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

    @error('amount')
    <p class="text-red-600 text-sm mt-1">{{$message}}</p>
    @enderror
</div>

<div class="mb-5 text-left">
    <label for="category_id" class="block text-xl mb-2">カテゴリー</label>
    <select id="category_id" name="category_id"
        class="w-full max-w-[200px] rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">選択してください</option>
        @foreach($categories as $category)
        <option value="{{$category->id}}" data-type="{{$category->type}}" {{ old('category_id', $record->category_id ?? '') == $category->id ? 'selected' : '' }}>
            {{$category->name}}
        </option>
        @endforeach
    </select>

    @error('category_id')
    <p class="text-red-600 text-sm mt-1">{{$message}}</p>
    @enderror
</div>

<div class="mb-6 text-left">
    <label for="memo" class="block text-xl mb-2">メモ</label>
    <textarea id="memo" name="memo" rows="10" class="w-full max-w-[400px] rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('memo', $record->memo ?? '') }}</textarea>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const categorySelect = document.getElementById('category_id');
    const categoryOptions = categorySelect.querySelectorAll('option');

    function filterCategories() {
        // 現在選択されているタイプ（income か expense）を取得
        const selectedType = document.querySelector('input[name="type"]:checked')?.value;

        categoryOptions.forEach(option => {
            // 「選択してください」の初期オプションは常に表示
            if (option.value === "") {
                option.style.display = 'block';
                return;
            }

            // オプションの data-type と、選ばれているラジオボタンが一致するかチェック
            if (option.getAttribute('data-type') === selectedType) {
                option.style.display = 'block'; // 一致したら表示
            } else {
                option.style.display = 'none';  // 違ったら非表示
            }
        });

        // もしタイプを切り替えたせいで「非表示になったカテゴリ」が選択された状態になっていたら、選択をリセットする
        const currentSelectedOption = categorySelect.options[categorySelect.selectedIndex];
        if (currentSelectedOption && currentSelectedOption.style.display === 'none') {
            categorySelect.value = "";
        }
    }

    // ラジオボタンがクリックされたら切り替えるイベントを設定
    typeRadios.forEach(radio => {
        radio.addEventListener('change', filterCategories);
    });

    // ページを開いた最初の瞬間にも一度実行（初期表示用）
    filterCategories();
});
</script>
