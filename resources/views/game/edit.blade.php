<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Videojuego') }}
            </h2>
            <a href="{{ route('game.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Añadir
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('game.update', ['game' => $game['nombre_inicial'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre_inicial">Nombre</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre_inicial') border-color:RED; @enderror" value="{{ $game['nombre_inicial'] }}" name="nombre_inicial" />
                            @foreach ($errors->get('nombre_inicial') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Imágen</label>
                            <input type="text" class="mt-1 block w-full" style="@error('imagen') border-color:RED; @enderror" value="{{ $game['imagen'] ?? '' }}" name="imagen" />
                            @foreach ($errors->get('imagen') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="video">Vídeo</label>
                            <input type="text" class="mt-1 block w-full" style="@error('video') border-color:RED; @enderror" value="{{ $game['video'] ?? '' }}" name="video" />
                            @foreach ($errors->get('video') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="web">Página Web</label>
                            <input type="text" class="mt-1 block w-full" style="@error('web') border-color:RED; @enderror" value="{{ $game['web'] ?? '' }}" name="web" />
                            @foreach ($errors->get('web') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="descripcionES">Descripción ES</label>
                            <textarea class="mt-1 block w-full" style="@error('descripcionES') border-color:RED; @enderror" name="descripcionES" minlength="6" maxlength="5000">{{ collect($game['traducciones'])->firstWhere('idioma.abreviatura', 'ES')['descripcion'] ?? '' }}</textarea>
                            @foreach ($errors->get('descripcionES') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="descripcionCA">Descripción CA</label>
                            <textarea class="mt-1 block w-full" style="@error('descripcionCA') border-color:RED; @enderror" name="descripcionCA" minlength="6" maxlength="5000">{{ collect($game['traducciones'])->firstWhere('idioma.abreviatura', 'CA')['descripcion'] ?? '' }}</textarea>
                            @foreach ($errors->get('descripcionCA') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="descripcionEN">Descripción EN</label>
                            <textarea class="mt-1 block w-full" style="@error('descripcionEN') border-color:RED; @enderror" name="descripcionEN" minlength="6" maxlength="5000">{{ collect($game['traducciones'])->firstWhere('idioma.abreviatura', 'EN')['descripcion'] ?? '' }}</textarea>
                            @foreach ($errors->get('descripcionEN') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="destacado" class="form-label">Destacado</label>
                            <select name="destacado" class="mt-1 block w-full">
                                <option value="N">No</option>
                                <option value="Y" {{ $game['destacado'] == 'Y' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="flex gap-2">
                                <label class="w-full">Género</label>
                            </div>
                            <div id="generos-container">
                                @php
                                    $oldGeneros = old('generos', $game['generos'] ?? [['nombre_inicial' => '']]);
                                @endphp
                                @foreach ($oldGeneros as $i => $genero)
                                    <div class="flex gap-2 mb-2" data-index="{{ $i }}">
                                        <select name="generos[{{ $i }}][nombre_inicial]" class="mt-1 block w-full" style="@error('generos.' . $i . '.nombre_inicial') border-color:RED; @enderror">
                                            <option value="">Selecciona un género</option>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre['nombre_inicial'] }}" {{ (isset($genero['nombre_inicial']) && $genero['nombre_inicial'] == $genre['nombre_inicial']) ? 'selected' : '' }}>
                                                    {{ $genre['nombre_inicial'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @foreach ($errors->get('generos.' . $i . '.nombre_inicial') as $message)
                                        <div class="text-red-500">{{ $message }}</div>
                                    @endforeach
                                @endforeach
                            </div>
                            <button type="button" onclick="addGenero()" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 py-1 rounded">Añadir género</button>
                            <button type="button" onclick="removeGenero()" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">Eliminar género</button>
                            @foreach ($errors->get('generos') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{route('game.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let generoIndex = (() => { // Encuentra el último índice de genero
        const containers = document.querySelectorAll('#generos-container [data-index]');
        if (containers.length === 0) return 0;
        return Math.max(...Array.from(containers).map(el => parseInt(el.getAttribute('data-index')))) + 1;
    })();
    function addGenero() {
        const container = document.getElementById('generos-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.setAttribute('data-index', generoIndex);

        let options = `<option value="">Selecciona un género</option>`;
        @foreach ($genres as $genre)
            options += `<option value="{{ $genre['nombre_inicial'] }}">{{ $genre['nombre_inicial'] }}</option>`;
        @endforeach

        div.innerHTML = `
            <select name="generos[${generoIndex}][nombre_inicial]" class="mt-1 block w-full">
                ${options}
            </select>
        `;
        
        container.appendChild(div);
        generoIndex++;
    }
    function removeGenero() {
        const container = document.getElementById('generos-container');
        if (container.children.length > 1) { // Previene eliminar el último genero
            container.lastElementChild.remove();
            generoIndex--;
        }
    }
</script>