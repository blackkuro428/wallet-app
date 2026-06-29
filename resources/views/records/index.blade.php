<x-app-layout>
    <div class="max-w-xl mx-auto pt-6 text-center">
        @if(session('success'))
        <div class="bg-green-200 text-green-700 p-2 mb-6 rounded mx-4 sm:mx-0">{{session('success')}}</div>
        @endif

        <h2 class="text-[54px] sm:text-6xl font-bold tracking-tight mb-3 sm:mb-6 {{$total >= 0 ? '' : 'text-red-600'}}">&yen;{{number_format($total)}}</h2>

        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-8 mt-4">
            <a href="{{route('records.create')}}" class="px-8 py-3.5 bg-black hover:bg-slate-800 text-white text-lg rounded-md shadow min-w-[150px] transition-colors duration-150">
                入力
            </a>

            <a href="{{route('records.history')}}" class="px-8 py-3.5 bg-white hover:bg-gray-50 text-slate-800 text-lg rounded-md border border-gray-400 shadow-sm min-w-[150px] transition-colors duration-150">
                収支履歴
            </a>
        </div>
    </div>
</x-app-layout>
