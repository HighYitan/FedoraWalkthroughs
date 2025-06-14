<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Noticia') }}
            </h2>
            <a href="{{ route('news.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('news.update', ['news' => $news['titulo_inicial'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <h3 class="font-bold mb-2 text-xl">Traducciones de la noticia</h3>
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
                                    <label>Título</label>
                                    <input type="text" class="mt-1 block w-full" name="traducciones[{{ $i }}][titulo]" style="@error('traducciones[{{ $i }}][titulo]') border-color:RED; @enderror" value="{{ $news['traducciones'][ $i ]['titulo'] }}" />
                                    @foreach ($errors->get("traducciones.$i.titulo") as $message)
                                        <div class="text-red-500">{{$message}}</div>
                                    @endforeach
                                </div>
                                <div class="mb-2">
                                    <label>Contenido</label>
                                    <textarea class="mt-1 block w-full" name="traducciones[{{ $i }}][contenido]" minlength="6" maxlength="10000" style="@error('traducciones[{{ $i }}][contenido]') border-color:RED; @enderror">{{ $news['traducciones'][ $i ]['contenido'] }}</textarea>
                                    @foreach ($errors->get("traducciones.$i.contenido") as $message)
                                        <div class="text-red-500">{{$message}}</div>
                                    @endforeach
                                </div>
                                <div class="mb-2">
                                    <label>Imagen (URL)</label>
                                    <input type="text" class="mt-1 block w-full" name="traducciones[{{ $i }}][imagen]" style="@error('traducciones[{{ $i }}][imagen]') border-color:RED; @enderror" value="{{ $news['traducciones'][ $i ]['imagen'] }}" />
                                    @foreach ($errors->get("traducciones.$i.imagen") as $message)
                                        <div class="text-red-500">{{$message}}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div>
                            <a href="{{route('news.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>