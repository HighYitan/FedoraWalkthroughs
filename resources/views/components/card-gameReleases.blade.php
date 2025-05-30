@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $gameRelease['nombre'] }}</h3>
    </div>
    <h5 class="mb-2 text-xl font-medium leading-tight">Fecha de lanzamiento: {{ $gameRelease['lanzamiento'] }}</h5>
    @if (!empty($gameRelease['videojuego']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Vídeojuego: {{ $gameRelease['videojuego']['nombre_inicial'] }}</h5>
    @endif
    <h5 class="mb-2 text-xl font-medium leading-tight">Region: {{ $gameRelease['region']['nombre_inicial'] }}</h5>
    <div class="mb-4">
        <h4 class="mb-2 text-2xl font-medium leading-tight">Plataformas</h4>
        <ul class="list-disc ml-6">
            @foreach ($gameRelease['plataformas'] as $plataforma)
                <li>
                    <p class="font-bold">Plataforma: {{ $plataforma['nombre'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mb-4">
        <h4 class="mb-2 text-2xl font-medium leading-tight">Desarrolladores</h4>
        <ul class="list-disc ml-6">
            @foreach ($gameRelease['desarrolladores'] as $desarrollador)
                <li>
                    <p class="font-bold">Nombre: {{ $desarrollador['nombre'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mb-4">
        <h4 class="mb-2 text-2xl font-medium leading-tight">Distribuidores</h4>
        <ul class="list-disc ml-6">
            @foreach ($gameRelease['distribuidores'] as $distribuidor)
                <li>
                    <p class="font-bold">Nombre: {{ $distribuidor['nombre'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
    @if (!empty($gameRelease['guias']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Guías</h4>
            <ul class="list-disc ml-6">
                @foreach ($gameRelease['guias'] as $guia)
                    <li>
                        <p class="font-bold">Título: {{ $guia['titulo'] }}</p>
                        <p class="font-bold">Puntuación Media: {{ $guia['puntuacion_media'] }}</p>
                        <p class="font-bold">Aprobada: {{ $guia['aprobada'] }}</p>
                        <p class="font-bold">Idioma: {{ $guia['idioma']['nombre'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($gameRelease['temas']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Temas del foro</h4>
            <ul class="list-disc ml-6">
                @foreach ($gameRelease['temas'] as $tema)
                    <li>
                        <p class="font-bold">Título: {{ $tema['titulo'] }}</p>
                        <p class="font-bold">Descripción: {{ $tema['descripcion'] }}</p>
                        <p class="font-bold">Idioma: {{ $tema['idioma']['nombre'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'gameRelease.index')
            <a href="{{route('gameRelease.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'gameRelease.show')
            <a href="{{route('gameRelease.show', ['gameRelease' => $gameRelease['id']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        @if (Route::currentRouteName() !== 'gameRelease.edit')
            <a href="{{route('gameRelease.edit', ['gameRelease' => $gameRelease['id']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        @endif
        <form action="{{route('gameRelease.destroy', ['gameRelease' => $gameRelease['id']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>