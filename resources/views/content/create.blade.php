<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Añadir una Sección') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('content.store') }}" method="post">
                        @csrf  <!-- Security Token -->
                        <div class="mb-3">
                            <label for="nombre">Nombre de la sección</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre') border-color:RED; @enderror" name="nombre" />
                            @foreach ($errors->get('nombre') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="contenido">Contenido de la sección</label>
                            <textarea class="mt-1 block w-full" style="@error('contenido') border-color:RED; @enderror" name="contenido" minlength="6" maxlength="10000"></textarea>
                            @foreach ($errors->get('contenido') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <input type="hidden" name="guia_id" value="{{ $guia }}">
                        <div>
                            <a href="{{route('guide.show', ['guide' => $guia])}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>