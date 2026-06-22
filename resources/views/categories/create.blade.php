<x-app-layout>
    <div class="max-w-7xl mx-[5px] sm:mx-auto px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{route('categories.index')}}" class="hover:text-gray-900 text-xl flex items-center gap-1">
                &lt; 戻る
            </a>
        </div>


        <form action="{{route('categories.store')}}" method="POST" class="max-w-md mx-auto">
            @csrf

            <!-- フォーム共通部品呼び出し -->
            @include('categories.form-field')

            <div class="mt-8 text-center">
                <button type="submit" class="px-8 py-3.5 bg-black hover:bg-slate-800 text-white text-lg rounded-md shadow min-w-[150px] transition-colors duration-150">
                    追加
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
