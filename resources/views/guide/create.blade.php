<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Añadir una Guía') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('guide.store') }}" method="post">
                        @csrf  <!-- Security Token -->
                        <div class="mb-3">
                            <label for="nombre_inicial">Título de la guía</label>
                            <input type="text" class="mt-1 block w-full" style="@error('titulo') border-color:RED; @enderror" name="titulo" />
                            @foreach ($errors->get('titulo') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="aprobada" class="form-label">Guía aprobada</label>
                            <select name="aprobada" class="mt-1 block w-full">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre_inicial">Lanzamiento</label>
                            <select name="nombre_inicial" class="mt-1 block w-full mb-1">
                                <option value="">Selecciona un lanzamiento</option>
                                @foreach ($gameReleases as $gameRelease)
                                    <option value="{{ $gameRelease['id'] }}">
                                        {{ $gameRelease['nombre'] - $gameRelease['region']['nombre_inicial'] - $gameRelease['lanzamiento'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div id="contenidos-container">
                                @php
                                    $oldContenidos = old('contenidos', [['nombre' => '', 'contenido' => '']]);
                                @endphp
                                @foreach ($oldContenidos as $i => $contenido)
                                    <div class="flex gap-2 mb-2" data-index="{{ $i }}">
                                        <label class="w-full">Sección</label>
                                        <input type="text" name="contenidos[{{ $i }}][nombre]" placeholder="Nombre" value="{{ $contenido['nombre'] ?? '' }}" class="mt-1 block w-full mb-1" />
                                        <label class="w-full">Contenido</label>
                                        <textarea class="mt-1 block w-full" name="contenidos[{{ $i }}][contenido]" minlength="6" maxlength="10000">{{ $contenido['contenido'] ?? '' }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addContenido()" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 py-1 rounded">Añadir contenido</button>
                            <button type="button" onclick="removeContenido()" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">Eliminar contenido</button>
                            @foreach ($errors->get('contenidos') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{route('guide.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let contenidoIndex = (() => { // Encuentra el último índice de contenido
        const containers = document.querySelectorAll('#contenidos-container [data-index]');
        if (containers.length === 0) return 0;
        return Math.max(...Array.from(containers).map(el => parseInt(el.getAttribute('data-index')))) + 1;
    })();
    function addContenido() {
        const container = document.getElementById('contenidos-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.setAttribute('data-index', contenidoIndex);

        div.innerHTML = `
            <label class="w-full">Sección</label>
            <input type="text" name="contenidos[${contenidoIndex}][nombre]" placeholder="Nombre" class="mt-1 block w-full mb-1" />
            <label class="w-full">Contenido</label>
            <textarea class="mt-1 block w-full" name="contenidos[${contenidoIndex}][contenido]" minlength="6" maxlength="10000"></textarea>
        `;
        container.appendChild(div);
        contenidoIndex++;
    }
    function removeContenido() {
        const container = document.getElementById('contenidos-container');
        if (container.children.length > 1) { // Previene eliminar el último contenido
            container.lastElementChild.remove();
            contenidoIndex--;
        }
    }
</script>