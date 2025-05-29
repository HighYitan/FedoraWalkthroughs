<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Añadir un Videojuego') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('game.store') }}" method="post">
                        @csrf  <!-- Security Token -->
                        <div class="mb-3">
                            <label for="nombre_inicial">Nombre</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre_inicial') border-color:RED; @enderror" name="nombre_inicial" />
                            @foreach ($errors->get('nombre_inicial') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Imágen</label>
                            <input type="text" class="mt-1 block w-full" style="@error('imagen') border-color:RED; @enderror" name="imagen" />
                            @foreach ($errors->get('imagen') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="video">Vídeo</label>
                            <input type="text" class="mt-1 block w-full" style="@error('video') border-color:RED; @enderror" name="video" />
                            @foreach ($errors->get('video') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="web">Página Web</label>
                            <input type="text" class="mt-1 block w-full" style="@error('web') border-color:RED; @enderror" name="web" />
                            @foreach ($errors->get('web') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="descripcionES">Descripción ES:</label>
                            <textarea class="mt-1 block w-full" style="@error('descripcionES') border-color:RED; @enderror" name="descripcionES" minlength="6" maxlength="5000"></textarea>
                            @foreach ($errors->get('descripcionES') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="descripcionCA">Descripción CA:</label>
                            <textarea class="mt-1 block w-full" style="@error('descripcionCA') border-color:RED; @enderror" name="descripcionCA" minlength="6" maxlength="5000"></textarea>
                            @foreach ($errors->get('descripcionCA') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="descripcionEN">Descripción EN:</label>
                            <textarea class="mt-1 block w-full" style="@error('descripcionEN') border-color:RED; @enderror" name="descripcionEN" minlength="6" maxlength="5000"></textarea>
                            @foreach ($errors->get('descripcionEN') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <div class="flex gap-2">
                                <label class="w-full">Género</label>
                            </div>
                            <div id="generos-container">
                                @php
                                    $oldGeneros = old('generos', [['nombre_inicial' => '']]);
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
                        <div class="mb-3">
                            <div id="lanzamientos-container">
                                @php
                                    $oldLanzamientos = old('lanzamientos', [[
                                        'nombre' => '',
                                        'lanzamiento' => '',
                                        'region' => '',
                                        'plataformas' => [['plataforma' => '']],
                                        'desarrolladores' => [['nombre' => '']],
                                        'distribuidores' => [['nombre' => '']],
                                    ]]);
                                @endphp
                                @foreach ($oldLanzamientos as $i => $lanzamiento)
                                    <div class="border p-3 mb-2" data-index="{{ $i }}">
                                        <label class="w-full">Lanzamiento</label>
                                        <input type="text" name="lanzamientos[{{ $i }}][nombre]" placeholder="Nombre" value="{{ $lanzamiento['nombre'] ?? '' }}" class="mt-1 block w-full mb-1" />
                                        <input type="date" name="lanzamientos[{{ $i }}][lanzamiento]" value="{{ $lanzamiento['lanzamiento'] ?? '' }}" class="mt-1 block w-full mb-1" />
                                        <select name="lanzamientos[{{ $i }}][region]" class="mt-1 block w-full mb-1">
                                            <option value="">Selecciona una región</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region['nombre_inicial'] }}" {{ (isset($lanzamiento['region']) && $lanzamiento['region'] == $region['nombre_inicial']) ? 'selected' : '' }}>
                                                    {{ $region['nombre_inicial'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- Plataformas --}}
                                        <div>
                                            <label>Plataformas</label>
                                            <div class="plataformas-container">
                                                @php $plataformas = $lanzamiento['plataformas'] ?? [['plataforma' => '']]; @endphp
                                                @foreach ($plataformas as $j => $plataforma)
                                                    <select name="lanzamientos[{{ $i }}][plataformas][{{ $j }}][plataforma]" class="mt-1 block w-full mb-1">
                                                        <option value="">Selecciona una plataforma</option>
                                                        @foreach ($platforms as $platform)
                                                            <option value="{{ $platform['nombre'] }}" {{ (isset($plataforma['plataforma']) && $plataforma['plataforma'] == $platform['nombre']) ? 'selected' : '' }}>
                                                                {{ $platform['nombre'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Desarrolladores --}}
                                        <div>
                                            <label>Desarrolladores</label>
                                            <div class="desarrolladores-container">
                                                @php $desarrolladores = $lanzamiento['desarrolladores'] ?? [['nombre' => '']]; @endphp
                                                @foreach ($desarrolladores as $j => $dev)
                                                    <select name="lanzamientos[{{ $i }}][desarrolladores][{{ $j }}][nombre]" class="mt-1 block w-full mb-1">
                                                        <option value="">Selecciona un desarrollador</option>
                                                        @foreach ($companies as $company)
                                                            <option value="{{ $company['nombre'] }}" {{ (isset($dev['nombre']) && $dev['nombre'] == $company['nombre']) ? 'selected' : '' }}>
                                                                {{ $company['nombre'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Distribuidores --}}
                                        <div>
                                            <label>Distribuidores</label>
                                            <div class="distribuidores-container">
                                                @php $distribuidores = $lanzamiento['distribuidores'] ?? [['nombre' => '']]; @endphp
                                                @foreach ($distribuidores as $j => $dist)
                                                    <select name="lanzamientos[{{ $i }}][distribuidores][{{ $j }}][nombre]" class="mt-1 block w-full mb-1">
                                                        <option value="">Selecciona un distribuidor</option>
                                                        @foreach ($companies as $company)
                                                            <option value="{{ $company['nombre'] }}" {{ (isset($dist['nombre']) && $dist['nombre'] == $company['nombre']) ? 'selected' : '' }}>
                                                                {{ $company['nombre'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addLanzamiento()" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 py-1 rounded">Añadir lanzamiento</button>
                            <button type="button" onclick="removeLanzamiento()" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 rounded">Eliminar lanzamiento</button>
                        </div>
                        <div>
                            <a href="{{route('game.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let generoIndex = {{ count(old('generos', [['nombre_inicial' => '']])) }};
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

    let lanzamientoIndex = {{ count(old('lanzamientos', [[]])) }};
    function addLanzamiento() {
        const container = document.getElementById('lanzamientos-container');
        const div = document.createElement('div');
        div.className = 'border p-3 mb-2';
        div.setAttribute('data-index', lanzamientoIndex);

        let regionOptions = `<option value="">Selecciona una región</option>`;
        @foreach ($regions as $region)
            regionOptions += `<option value="{{ $region['nombre_inicial'] }}">{{ $region['nombre_inicial'] }}</option>`;
        @endforeach
        let platformOptions = `<option value="">Selecciona una plataforma</option>`;
        @foreach ($platforms as $platform)
            platformOptions += `<option value="{{ $platform['nombre'] }}">{{ $platform['nombre'] }}</option>`;
        @endforeach
 
        let companyOptions = `<option value="">Selecciona una compañía</option>`;
        @foreach ($companies as $company)
            companyOptions += `<option value="{{ $company['nombre'] }}">{{ $company['nombre'] }}</option>`;
        @endforeach

        div.innerHTML = `
            <label class="w-full">Lanzamiento</label>
            <input type="text" name="lanzamientos[${lanzamientoIndex}][nombre]" placeholder="Nombre" class="mt-1 block w-full mb-1" />
            <input type="date" name="lanzamientos[${lanzamientoIndex}][lanzamiento]" class="mt-1 block w-full mb-1" />
            <select name="lanzamientos[${lanzamientoIndex}][region]" class="mt-1 block w-full mb-1">
                ${regionOptions}
            </select>
            <div>
                <label>Plataformas</label>
                <select name="lanzamientos[${lanzamientoIndex}][plataformas][0][plataforma]" class="mt-1 block w-full mb-1">
                    ${platformOptions}
                </select>
            </div>
            <div>
                <label>Desarrolladores</label>
                <select name="lanzamientos[${lanzamientoIndex}][desarrolladores][0][nombre]" class="mt-1 block w-full mb-1">
                    ${companyOptions}
                </select>
            </div>
            <div>
                <label>Distribuidores</label>
                <select name="lanzamientos[${lanzamientoIndex}][distribuidores][0][nombre]" class="mt-1 block w-full mb-1">
                    ${companyOptions}
                </select>
            </div>
        `;
        container.appendChild(div);
        lanzamientoIndex++;
    }
</script>