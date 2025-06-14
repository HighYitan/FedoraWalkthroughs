<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Guía') }}
            </h2>
            <a href="{{ route('guide.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('guide.update', ['guide' => $guide['id'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <div class="mb-3">
                            <label for="titulo">Título de la guía</label>
                            <input type="text" class="mt-1 block w-full" style="@error('titulo') border-color:RED; @enderror" value="{{ $guide['titulo'] }}" name="titulo" />
                            @foreach ($errors->get('titulo') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="lanzamiento_id">Lanzamiento</label>
                            <select name="lanzamiento_id" class="mt-1 block w-full mb-1">
                                <option value="">Selecciona un lanzamiento</option>
                                @foreach ($gameReleases as $gameRelease)
                                    @php
                                        $guideLanzamientoId = Crypt::decryptString($guide['lanzamiento']['id']);
                                        $gameReleaseId = Crypt::decryptString($gameRelease['id']);
                                    @endphp
                                    <option value="{{ $gameRelease['id'] }}" {{ ($guideLanzamientoId == $gameReleaseId) ? 'selected' : '' }}>
                                        {{ $gameRelease['nombre'] . '-' . $gameRelease['region']['nombre_inicial'] . '-' . $gameRelease['lanzamiento'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="idioma">Idioma</label>
                            <select name="idioma" class="mt-1 block w-full mb-1">
                                <option value="">Selecciona un idioma</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language['abreviatura'] }}" {{ (isset($guide['idioma']['abreviatura']) && $guide['idioma']['abreviatura'] == $language['abreviatura']) ? 'selected' : '' }}>{{ $language['nombre'] }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('idioma') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="aprobado" class="form-label">Guía aprobada</label>
                            <select name="aprobado" class="mt-1 block w-full">
                                <option value="0" {{ (isset($guide['aprobada']) && $guide['aprobada'] == "No") ? 'selected' : '' }}>No</option>
                                <option value="1" {{ (isset($guide['aprobada']) && $guide['aprobada'] == "Sí") ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                        <div>
                            <a href="{{route('guide.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>