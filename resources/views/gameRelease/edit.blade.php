<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Lanzamiento') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('gameRelease.update', ['gameRelease' => $gameRelease['id'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre_inicial">Videojuego</label>
                            <select name="nombre_inicial" class="mt-1 block w-full mb-1">
                                <option value="">Selecciona un videojuego</option>
                                @foreach ($games as $game)
                                    <option value="{{ $game['nombre_inicial'] }}" {{ (isset($gameRelease['videojuego']['nombre_inicial']) && $gameRelease['videojuego']['nombre_inicial'] == $game['nombre_inicial']) ? 'selected' : '' }}>
                                        {{ $game['nombre_inicial'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre">Nombre del Lanzamiento</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre') border-color:RED; @enderror" value="{{ $gameRelease['nombre'] }}" name="nombre" />
                            @foreach ($errors->get('nombre') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="lanzamiento">Fecha</label>
                            <input type="date" class="mt-1 block w-full" style="@error('lanzamiento') border-color:RED; @enderror" value="{{ $gameRelease['lanzamiento'] }}" name="lanzamiento" />
                            @foreach ($errors->get('lanzamiento') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="region">Región</label>
                            <select name="region" class="mt-1 block w-full mb-1">
                                <option value="">Selecciona una región</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region['nombre_inicial'] }}" {{ (isset($gameRelease['region']['nombre_inicial']) && $gameRelease['region']['nombre_inicial'] == $region['nombre_inicial']) ? 'selected' : '' }}>
                                        {{ $region['nombre_inicial'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="flex gap-2">
                                <label class="w-full">Plataformas</label>
                            </div>
                            <div id="plataformas-container">
                                @php
                                    $oldPlataformas = old('plataformas', $gameRelease['plataformas'] ?? [['plataforma' => '']]);
                                @endphp
                                @foreach ($oldPlataformas as $i => $plataforma)
                                    <div class="flex gap-2 mb-2" data-index="{{ $i }}">
                                        <select name="plataformas[{{ $i }}][plataforma]" class="mt-1 block w-full mb-1">
                                            <option value="">Selecciona una plataforma</option>
                                            @foreach ($platforms as $platform)
                                                <option value="{{ $platform['nombre'] }}" {{ (isset($plataforma['nombre']) && $plataforma['nombre'] == $platform['nombre']) ? 'selected' : '' }}>
                                                    {{ $platform['nombre'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addPlataforma()" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 py-1 rounded">Añadir plataforma</button>
                            <button type="button" onclick="removePlataforma()" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">Eliminar plataforma</button>
                            @foreach ($errors->get('plataformas') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <div class="flex gap-2">
                                <label class="w-full">Desarrolladores</label>
                            </div>
                            <div id="desarrolladores-container">
                                @php
                                    $oldDesarrolladores = old('desarrolladores', $gameRelease['desarrolladores'] ?? [['nombre' => '']]);
                                @endphp
                                @foreach ($oldDesarrolladores as $i => $desarrollador)
                                    <div class="flex gap-2 mb-2" data-index="{{ $i }}">
                                        <select name="desarrolladores[{{ $i }}][nombre]" class="mt-1 block w-full mb-1">
                                            <option value="">Selecciona una compañía</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company['nombre'] }}" {{ (isset($desarrollador['nombre']) && $desarrollador['nombre'] == $company['nombre']) ? 'selected' : '' }}>
                                                    {{ $company['nombre'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addDesarrollador()" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 py-1 rounded">Añadir desarrollador</button>
                            <button type="button" onclick="removeDesarrollador()" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">Eliminar desarrollador</button>
                            @foreach ($errors->get('desarrolladores') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <div class="flex gap-2">
                                <label class="w-full">Distrubuidores</label>
                            </div>
                            <div id="distribuidores-container">
                                @php
                                    $oldDistribuidores = old('distribuidores', $gameRelease['distribuidores'] ?? [['nombre' => '']]);
                                @endphp
                                @foreach ($oldDistribuidores as $i => $distribuidor)
                                    <div class="flex gap-2 mb-2" data-index="{{ $i }}">
                                        <select name="distribuidores[{{ $i }}][nombre]" class="mt-1 block w-full mb-1">
                                            <option value="">Selecciona una compañía</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company['nombre'] }}" {{ (isset($distribuidor['nombre']) && $distribuidor['nombre'] == $company['nombre']) ? 'selected' : '' }}>
                                                    {{ $company['nombre'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addDistribuidor()" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 py-1 rounded">Añadir distribuidor</button>
                            <button type="button" onclick="removeDistribuidor()" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">Eliminar distribuidor</button>
                            @foreach ($errors->get('distribuidores') as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{route('gameRelease.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let plataformaIndex = (() => { // Encuentra el último índice de plataforma
        const containers = document.querySelectorAll('#plataformas-container [data-index]');
        if (containers.length === 0) return 0;
        return Math.max(...Array.from(containers).map(el => parseInt(el.getAttribute('data-index')))) + 1;
    })();
    function addPlataforma() {
        const container = document.getElementById('plataformas-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.setAttribute('data-index', plataformaIndex);

        let options = `<option value="">Selecciona una plataforma</option>`;
        @foreach ($platforms as $platform)
            options += `<option value="{{ $platform['nombre'] }}">{{ $platform['nombre'] }}</option>`;
        @endforeach

        div.innerHTML = `
            <select name="plataformas[${plataformaIndex}][plataforma]" class="mt-1 block w-full">
                ${options}
            </select>
        `;
        container.appendChild(div);
        plataformaIndex++;
    }
    function removePlataforma() {
        const container = document.getElementById('plataformas-container');
        if (container.children.length > 1) { // Previene eliminar la última plataforma
            container.lastElementChild.remove();
            plataformaIndex--;
        }
    }
    let desarrolladorIndex = (() => { // Encuentra el último índice de desarrollador
        const containers = document.querySelectorAll('#desarrolladores-container [data-index]');
        if (containers.length === 0) return 0;
        return Math.max(...Array.from(containers).map(el => parseInt(el.getAttribute('data-index')))) + 1;
    })();
    function addDesarrollador() {
        const container = document.getElementById('desarrolladores-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.setAttribute('data-index', desarrolladorIndex);

        let options = `<option value="">Selecciona una compañía</option>`;
        @foreach ($companies as $company)
            options += `<option value="{{ $company['nombre'] }}">{{ $company['nombre'] }}</option>`;
        @endforeach

        div.innerHTML = `
            <select name="desarrolladores[${desarrolladorIndex}][nombre]" class="mt-1 block w-full">
                ${options}
            </select>
        `;
        container.appendChild(div);
        desarrolladorIndex++;
    }
    function removeDesarrollador() {
        const container = document.getElementById('desarrolladores-container');
        if (container.children.length > 1) { // Previene eliminar el último desarrollador
            container.lastElementChild.remove();
            desarrolladorIndex--;
        }
    }
    let distribuidorIndex = (() => { // Encuentra el último índice de distribuidor
        const containers = document.querySelectorAll('#distribuidores-container [data-index]');
        if (containers.length === 0) return 0;
        return Math.max(...Array.from(containers).map(el => parseInt(el.getAttribute('data-index')))) + 1;
    })();
    function addDistribuidor() {
        const container = document.getElementById('distribuidores-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.setAttribute('data-index', distribuidorIndex);

        let options = `<option value="">Selecciona una compañía</option>`;
        @foreach ($companies as $company)
            options += `<option value="{{ $company['nombre'] }}">{{ $company['nombre'] }}</option>`;
        @endforeach

        div.innerHTML = `
            <select name="distribuidores[${distribuidorIndex}][nombre]" class="mt-1 block w-full">
                ${options}
            </select>
        `;
        container.appendChild(div);
        distribuidorIndex++;
    }
    function removeDistribuidor() {
        const container = document.getElementById('distribuidores-container');
        if (container.children.length > 1) { // Previene eliminar el último distribuidor
            container.lastElementChild.remove();
            distribuidorIndex--;
        }
    }
</script>