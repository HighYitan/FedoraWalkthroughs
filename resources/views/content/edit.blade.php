<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Sección') }}
            </h2>
            <form action="{{ route('content.create') }}" method="GET" class="ml-auto">
                @csrf
                <input type="hidden" name="guia_id" value="{{ $guide['id'] }}">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Añadir
                </button>
            </form>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('content.update', ['content' => $contentGuide['id'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre">Nombre de la sección</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre') border-color:RED; @enderror" value="{{ $contentGuide['name'] }}" name="nombre" />
                            @foreach ($errors->get('nombre') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="contenido">Contenido de la sección</label>
                            <textarea class="mt-1 block w-full" style="@error('contenido') border-color:RED; @enderror" name="contenido" minlength="6" maxlength="10000">{{ $contentGuide['content'] }}</textarea>
                            @foreach ($errors->get('contenido') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <input type="hidden" name="guia_id" value="{{ $guide['id'] }}">
                        <div>
                            <a href="{{route('guide.show', ['guide' => $guide['id']])}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>