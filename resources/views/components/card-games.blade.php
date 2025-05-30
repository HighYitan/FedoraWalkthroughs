@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $game['nombre_inicial'] }}</h3>
    </div>
    @if (isset($game['puntuacion_media']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Puntuación media: {{ $game['puntuacion_media'] }}</h5>
    @endif
    <h5 class="mb-2 text-xl font-medium leading-tight">Destacado: {{ $game['destacado'] }}</h5>
    @if (isset($game['imagen']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Imágen: <span class="break-all"><a href="{{ $game['imagen'] }}" target="_blank" class="text-blue-600 underline">{{ $game['imagen'] }}</a></h5>
    @endif
    @if (isset($game['video']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Vídeo: <span class="break-all"><a href="{{ $game['video'] }}" target="_blank" class="text-blue-600 underline">{{ $game['video'] }}</a></h5>
    @endif
    @if (isset($game['web']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Página Web: <span class="break-all"><a href="{{ $game['web'] }}" target="_blank" class="text-blue-600 underline">{{ $game['web'] }}</a></h5>
    @endif
    @foreach ($game['traducciones'] as $traduccion)
        @if ($traduccion['idioma']['abreviatura'] === 'ES')
            <h5 class="mb-2 text-xl font-medium leading-tight">Descripción ES: {{ $traduccion['descripcion'] }}</h5>
        @elseif ($traduccion['idioma']['abreviatura'] === 'CA')
            <h5 class="mb-2 text-xl font-medium leading-tight">Descripción CA: {{ $traduccion['descripcion'] }}</h5>
        @elseif ($traduccion['idioma']['abreviatura'] === 'EN')
            <h5 class="mb-2 text-xl font-medium leading-tight">Descripción EN: {{ $traduccion['descripcion'] }}</h5>
        @endif
    @endforeach
    @php
        $generosPorIdioma = [
            'ES' => [],
            'CA' => [],
            'EN' => [],
        ];
        foreach ($game['generos'] as $genero) {
            foreach ($genero['traducciones'] as $traduccion) {
                $abbr = $traduccion['idioma']['abreviatura'];
                if (isset($generosPorIdioma[$abbr])) {
                    $generosPorIdioma[$abbr][] = $traduccion['nombre'];
                }
            }
        }
    @endphp
    @foreach ($generosPorIdioma as $abbr => $nombres)
        @if (count($nombres))
            <h5 class="mb-2 text-xl font-medium leading-tight">
                @if (count($nombres) === 1)
                    Género {{ $abbr }}: {{ $nombres[0] }}
                @else
                    Géneros {{ $abbr }}: {{ implode(', ', $nombres) }}
                @endif
            </h5>
        @endif
    @endforeach
    @if (!empty($game['lanzamientos']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Lanzamientos</h4>
            <ul class="list-disc ml-6">
                @foreach ($game['lanzamientos'] as $lanzamiento)
                    <li>
                        <p class="font-bold">Nombre: {{ $lanzamiento['nombre'] }}</p>
                        <p class="font-bold">Fecha: {{ $lanzamiento['lanzamiento'] }}</p>
                        <p class="font-bold">Región: {{ $lanzamiento['region']['nombre_inicial'] }}</p> 
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'game.index')
            <a href="{{route('game.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'game.show')
            <a href="{{route('game.show', ['game' => $game['nombre_inicial']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        @if (Route::currentRouteName() !== 'game.edit')
            <a href="{{route('game.edit', ['game' => $game['nombre_inicial']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        @endif
        <form action="{{route('game.destroy', ['game' => $game['nombre_inicial']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>