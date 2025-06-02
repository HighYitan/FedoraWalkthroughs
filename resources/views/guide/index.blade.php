<x-app-layout>
    <!-- Header del listado de Guías -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Listado de Guías') }}
            </h2>
            <a href="{{ route('guide.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Añadir
            </a>
        </div>
    </x-slot>

    <!-- Listado de Guías -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Se muestran los elementos en forma de Card -->
                    @each('components.card-guides',$guides,'guide')
                    {{-- @if(method_exists($guides, 'links'))
                        {{ $guides->links() }}
                    @endif --}} <!-- Paginación -->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>