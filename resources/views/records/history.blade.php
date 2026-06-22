<x-app-layout>
    <div class="w-full pt-8 px-4 mb-6 text-left">
        @if(session('success'))
        <div class="w-full max-w-[700px] mx-auto bg-green-200 text-green-700 p-2 rounded">{{session('success')}}</div>
        @endif

        @if(session('delete'))
        <div class="w-full max-w-[700px] mx-auto text-left bg-red-200 text-red-600 p-2 rounded">{{session('delete')}}</div>
        @endif
    </div>

    <div class="flex flex-col items-center pt-20 space-y-6 w-full">
        @foreach($records as $record)

        @if($record->type == 0)
        <div class="p-5 shadow w-full max-w-[700px] mx-auto rounded-lg flex flex-col gap-4 bg-[#A8E2FF]">
            <div class="flex justify-start gap-6 items-center">
                <h4 class="text-lg">日付：{{$record->date}}</h4>
                <h4 class="text-lg">カテゴリー：{{$record->category->name ?? '未分類'}}</h4>
            </div>
            <div class="flex justify-between items-center pt-2">
                <h3 class="text-3xl">&yen;{{number_format($record->amount)}}</h3>
                <a href="{{route('records.show', $record->id)}}" class="px-8 py-3.5 bg-white hover:bg-gray-50 text-slate-800 text-lg rounded-md border border-gray-400 shadow-sm min-w-[100px] transition-colors duration-150">
                    詳細
                </a>
            </div>
        </div>
        @else
        <div class="p-5 shadow w-full max-w-[700px] mx-auto rounded-lg flex flex-col gap-4 bg-[#FFAEAE]">
            <div class="flex justify-start gap-6 items-center">
                <h4 class="text-lg">日付：{{$record->date}}</h4>
                <h4 class="text-lg">カテゴリー：{{$record->category->name ?? '未分類'}}</h4>
            </div>
            <div class="flex justify-between items-center pt-2">
                <h3 class="text-3xl">&yen;{{number_format($record->amount)}}</h3>
                <a href="{{route('records.show', $record->id)}}" class="px-8 py-3.5 bg-white hover:bg-gray-50 text-slate-800 text-lg rounded-md border border-gray-400 shadow-sm min-w-[100px] transition-colors duration-150">
                    詳細
                </a>
            </div>
        </div>
        @endif

        @endforeach

        <div class="w-full max-w-[700px] mx-auto pt-4 px-2 flex justify-center [&_p]:hidden">
            {{$records->links()}}
        </div>
    </div>
</x-app-layout>
