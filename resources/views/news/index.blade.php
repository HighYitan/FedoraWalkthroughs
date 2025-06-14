<x-app-layout>
    <!-- Header del listado de Noticias -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Listado de Noticias') }}
            </h2>
            <a href="{{ route('news.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear
            </a>
        </div>
    </x-slot>

    <!-- Listado de Noticias -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Se muestran los elementos en forma de Card -->
                    @each('components.card-news',$news,'news')
                    {{-- @if(method_exists($news, 'links'))
                        {{ $news->links() }}
                    @endif --}} <!-- Paginación -->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>