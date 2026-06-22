<x-app-layout>
    <div class="max-w-7xl mx-[5px] sm:mx-auto px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{route('records.show', $record->id)}}" class="hover:text-gray-900 text-xl flex items-center gap-1">
                &lt; 戻る
            </a>
        </div>
        <form action="{{route('records.update', $record->id)}}" method="POST" class="max-w-md mx-auto">
            @csrf
            @method('PUT')

            <!-- フォーム共通部品呼び出し -->
            @include('records.form-field', ['categories'=>$categories, 'record'=>$record])

            <div class="flex justify-start items-center gap-[10px] sm:gap-24 mt-4">
                <button type="submit" class="flex-1 sm:flex-none px-8 py-3.5 bg-black hover:bg-slate-800 text-white text-lg rounded-md shadow sm:min-w-[150px] transition-colors duration-150">
                    保存
                </button>

                <button type="button" onclick="if(confirm('本当に削除しますか？')) { document.getElementById('delete-form').submit(); }" class="flex-1 sm:flex-none px-8 py-3.5 bg-white hover:bg-gray-50 text-slate-800 text-lg rounded-md border border-gray-400 shadow-sm sm:min-w-[150px] transition-colors duration-150">
                    削除
                </button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('records.delete', $record->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-app-layout>
