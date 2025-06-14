<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Género') }}
            </h2>
            <a href="{{ route('genre.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Añadir
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('genre.update', ['genre' => $genre['nombre_inicial'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <h3 class="font-bold mb-2 text-xl">Traducciones del género</h3>
                        @php
                            $idiomas = [
                                ['abreviatura' => 'ES', 'nombre' => 'Español'],
                                ['abreviatura' => 'CA', 'nombre' => 'Català'],
                                ['abreviatura' => 'EN', 'nombre' => 'English'],
                            ];
                        @endphp
                        @foreach ($idiomas as $i => $idioma)
                            <div class="mb-3">
                                <h5 class="font-semibold mb-2">{{ $idioma['nombre'] }}</h5>
                                <input type="hidden" name="traducciones[{{ $i }}][idioma]" value="{{ $idioma['abreviatura'] }}">
                                <div class="mb-2">
                                    <label>Nombre</label>
                                    <input type="text" class="mt-1 block w-full" name="traducciones[{{ $i }}][nombre]" style="@error('traducciones[{{ $i }}][nombre]') border-color:RED; @enderror" value="{{ $genre['traducciones'][ $i ]['nombre'] }}" />
                                    @foreach ($errors->get("traducciones.$i.nombre") as $message)
                                        <div class="text-red-500">{{$message}}</div>
                                    @endforeach
                                </div>
                                <div class="mb-2">
                                    <label>Descripción</label>
                                    <textarea class="mt-1 block w-full" name="traducciones[{{ $i }}][descripcion]" minlength="6" maxlength="1000" style="@error('traducciones[{{ $i }}][descripcion]') border-color:RED; @enderror">{{ $genre['traducciones'][ $i ]['descripcion'] }}</textarea>
                                    @foreach ($errors->get("traducciones.$i.descripcion") as $message)
                                        <div class="text-red-500">{{$message}}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div>
                            <a href="{{route('genre.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>