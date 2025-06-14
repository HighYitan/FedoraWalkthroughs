<x-app-layout>
    <!-- Header de la Plataforma -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mostrar Plataforma') }}
            </h2>
            <a href="{{ route('platform.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Añadir
            </a>
        </div>
    </x-slot>
    <!-- Plataforma -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-card-platforms :platform="$platform" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>