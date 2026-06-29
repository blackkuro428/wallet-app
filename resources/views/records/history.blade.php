<x-app-layout>
    <div class="w-full pt-8 px-4 mb-6 text-left">
        @if(session('success'))
        <div class="w-full max-w-[700px] mx-auto bg-green-200 text-green-700 p-2 rounded">{{session('success')}}</div>
        @endif

        @if(session('delete'))
        <div class="w-full max-w-[700px] mx-auto text-left bg-red-200 text-red-600 p-2 rounded">{{session('delete')}}</div>
        @endif
    </div>

    <div class="flex items-center justify-center pt-12 w-full">
        <a href="{{route('records.history')}}" class="px-4 py-2 border {{$view != 'analytics' ? 'bg-black text-white border-black hover:bg-slate-800' : 'bg-white border-gray-400 hover:bg-gray-50'}} shadow-sm transition-colors duration-150 rounded-l">
            履歴
        </a>
        <a href="{{route('records.history', ['view'=>'analytics'])}}" class="px-4 py-2 border {{$view == 'analytics' ? 'bg-black text-white border-black hover:bg-slate-800' : 'bg-white border-gray-400 hover:bg-gray-50'}} shadow-sm transition-colors duration-150 rounded-r">
            内訳
        </a>
    </div>
    @if($view == 'analytics')
    <div class="space-y-4 pt-8 w-full px-4">
        @if(count($analyticsData) == 0)
        <div class="text-center py-4 bg-white border rounded-md shadow-sm max-w-[700px] mx-auto border-gray-200">
            <p class="text-lg">登録された支出データはありません</p>
        </div>
        @endif

        @foreach($analyticsData as $month=>$data)
        <details class="max-w-[700px] mx-auto bg-white border rounded-md shadow group overflow-hidden">
            <summary class="p-4 bg-[#FFAEAE] rounded-md flex justify-between items-center cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                <span>{{$month}}：&yen;{{number_format($data['month_total'])}}</span>
                <svg class="w-5 h-5 transition-transform duration-90 group-open:rotate-180"
                    fill="none"
                    viewBox=0 0 24 24
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </summary>

            <div class="p-4 space-y-2">
                @foreach($data['categories'] as $item)
                <div class="flex justify-between bg-white p-2 border-b {{!$loop->last ? 'border-gray-400' : 'border-none'}} gap-4">
                    <span>{{$item->category_name}}</span>
                    <span class="shrink-0">&yen;{{number_format($item->total_amount)}}（{{$item->percentage}}%）</span>
                </div>
                @endforeach
            </div>
        </details>
        @endforeach
    </div>
    @else
    <div class="pt-8 space-y-4 w-full px-4">
        @if(count($historyByMonth) == 0)
        <div class="w-full text-center py-4 bg-white border rounded-md shadow-sm max-w-[700px] mx-auto border-gray-200">
            <p class="text-lg">登録された収支データはありません</p>
        </div>
        @endif

        @foreach($historyByMonth as $month=>$data)
        <details class="max-w-[700px] mx-auto rounded-md group overflow-hidden">
            <summary class="p-4 bg-white rounded-md border flex justify-between items-center cursor-pointer list-none [&::-webkit-details-maeker]:hidden hover:bg-gray-50 duration-150">
                <p>{{$month}}：<span class="{{$data['monthTotal'] >= 0 ? '' : 'text-red-600'}}">&yen;{{number_format($data['monthTotal'])}}</span></p>

                <svg class="w-5 h-5 transition-transform duration-90 group-open:rotate-180"
                    fill="none"
                    viewBox=0 0 24 24
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </summary>

            <div class="p-4 space-y-4">
                @foreach($data['records'] as $record)
                <div class="p-5 shadow w-full max-w-[700px] mx-auto rounded-lg sm:flex sm:flex-col gap-4 {{$record->type == 0 ? 'bg-[#A8E2FF]' : 'bg-[#FFAEAE]'}}">
                    <div class="sm:flex sm:flex-row justify-start gap-1 sm:gap-6 items-center">
                        <h4 class="text-lg">日付：{{$record->date}}</h4>
                        <h4 class="text-lg">カテゴリー：{{$record->category->name ?? '未分類'}}</h4>
                    </div>
                    <div class="relative sm:static sm:flex flex-col sm:flex-row sm:justify-between sm:items-center pt-2 h-28 sm:h-auto">
                        <h3 class="text-3xl">&yen;{{number_format($record->amount)}}</h3>
                        <a href="{{route('records.show', $record->id)}}" class="absolute bottom-0 right-0 sm:static px-8 py-3.5 bg-white hover:bg-gray-50 text-slate-800 text-lg rounded-md border border-gray-400 shadow-sm min-w-[100px] transition-colors duration-150">
                            詳細
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </details>
        @endforeach
    </div>
    @endif
</x-app-layout>
