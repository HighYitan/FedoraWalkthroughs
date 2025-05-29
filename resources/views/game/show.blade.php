<x-app-layout>
    <!-- Header del Videojuego -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mostrar Videojuego') }}
            </h2>
            <a href="{{ route('game.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear
            </a>
        </div>
    </x-slot>
    <!-- Videojuego -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-card-games :game="$game" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>