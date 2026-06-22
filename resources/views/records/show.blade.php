<x-app-layout>
    <div class="max-w-7xl mx-[5px] sm:mx-auto px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{route('records.history')}}" class="hover:text-gray-900 text-xl flex items-center gap-1">
                &lt; 戻る
            </a>
        </div>

        <div class="max-w-md mx-auto">
            <!-- 読み取り専用フォーム呼び出し -->
            @include('records.form-field-read', ['categories'=>$categories, 'record'=>$record])

            <div class="mt-8 text-center">
                <a href="{{route('records.edit', $record->id)}}" class="inline-block px-8 py-3.5 bg-black hover:bg-slate-800 text-white text-lg rounded-md shadow min-w-[150px] transition-colors duration-150">
                    編集
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
