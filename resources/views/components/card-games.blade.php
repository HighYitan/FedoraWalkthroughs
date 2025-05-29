@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $game['nombre_inicial'] }}</h3>
    </div>
    @if (isset($game['puntuacion_media']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Puntuación media: {{ $game['puntuacion_media'] }}</h5>
    @endif
    <h5 class="mb-2 text-xl font-medium leading-tight">Destacado: <span class="break-all">{{ $game['destacado'] }}</span></h5>
    @if (isset($game['imagen']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Imágen: {{ $game['imagen'] }}</h5>
    @endif
    @if (isset($game['video']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Vídeo: {{ $game['video'] }}</h5>
    @endif
    @if (isset($game['web']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Página Web: {{ $game['web'] }}</h5>
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
                Género {{ $abbr }}: {{ implode(', ', $nombres) }}
            </h5>
        @endif
    @endforeach
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