<x-app-layout>
    <!-- Header del Usuario -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mostrar Usuario') }}
            </h2>
        </div>
    </x-slot>
    <!-- Usuario -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-card-users :user="$user" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>