<x-app-layout>
    <div class="w-full pt-8 px-4 mb-6 text-center">
        @if(session('success'))
        <div class="w-full max-w-[700px] mx-auto bg-green-200 text-green-700 p-2 rounded">{{session('success')}}</div>
        @endif

        @if(session('delete'))
        <div class="w-full max-w-[700px] mx-auto bg-red-200 text-red-600 p-2 rounded">{{session('delete')}}</div>
        @endif
    </div>

    <div class="mt-20 text-center mb-12">
        <a href="{{route('categories.create')}}" class="nline-block px-8 py-3.5 bg-black hover:bg-slate-800 text-white text-lg rounded-md shadow min-w-[150px] transition-colors duration-150">
            カテゴリー追加
        </a>
    </div>

    <div class="w-full max-w-[700px] mx-auto space-y-12">
        @foreach($categories->groupBy('type') as $type=>$group)
        <div>
            <div class="w-full w-auto p-2 mb-4 {{ $type == 0 ? 'bg-[#A8E2FF]' : 'bg-[#FFAEAE]' }}">
                <h3 class="text-3xl text-center">{{$type == 0 ? '収入' : '支出'}}</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($group as $category)
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm flex justify-between items-center">
                    <h4 class="text-xl">{{$category->name}}</h4>
                    @if($category->user_id != null)
                    <a href="{{route('categories.edit', $category->id)}}" class="p-0.5 bg-white hover:bg-gray-50 text-center text-slate-800 text- rounded-md border border-gray-400 shadow-sm min-w-[80px] transition-colors duration-150">
                        編集
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
