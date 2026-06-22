<div class="mb-5 text-left">
    <label class="block text-xl mb-2">収支チェック</label>
    <div class="flex items-center gap-4">
        <label class="flex items-center cursor-pointer px-2 py-1 text-lg rounded-md transition-colors bg-[#A8E2FF]">
            <input type="radio" name="type" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                {{old('type', $category->type ?? '1') == '0' ? 'checked' : ''}}>
            <span class="ml-2 text-gray-700 px-3 py-1 rounded text-lg">収入</span>
        </label>
        <label class="flex items-center cursor-pointer px-2 py-1 text-lg rounded-md transition-colors bg-[#FFAEAE]">
            <input type="radio" name="type" value="1" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                {{old('type', $category->type ?? '1') == '1' ? 'checked' : ''}}>
            <span class="ml-2 text-gray-700 px-3 py-1 rounded text-lg">支出</span>
        </label>
    </div>

    @error('type')
    <p class="text-red-600 text-sm mt-1">{{$message}}</p>
    @enderror
</div>

<div class="mb-5 text-left">
    <label class="block text-xl mb-2">カテゴリー名</label>
    <input type="text" id="name" name="name" value="{{old('name', $category->name ?? '')}}"
        class="w-auto max-w-md rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

    @error('name')
    <p class="text-red-600 text-sm mt-1">{{$message}}</p>
    @enderror
</div>
