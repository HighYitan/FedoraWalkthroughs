<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Añadir una Plataforma') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('platform.store') }}" method="post">
                        @csrf  <!-- Security Token -->
                        <div class="mb-3">
                            <label for="nombre">Nombre de la plataforma</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre') border-color:RED; @enderror" name="nombre" />
                            @foreach ($errors->get('nombre') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="lanzamiento">Año de lanzamiento</label>
                            <input type="number" class="mt-1 block w-full" style="@error('lanzamiento') border-color:RED; @enderror" name="lanzamiento" min="1900" max="{{ date('Y') }}" />
                            @foreach ($errors->get('lanzamiento') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="desarrollador">Desarrollador</label>
                            <select name="desarrollador" class="mt-1 block w-full mb-1">
                                @foreach ($companies as $company)
                                    <option value="{{ $company['nombre'] }}">{{ $company['nombre'] }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('desarrollador') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Imagen</label>
                            <input type="url" class="mt-1 block w-full" style="@error('imagen') border-color:RED; @enderror" name="imagen" />
                            @foreach ($errors->get('imagen') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{route('platform.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>