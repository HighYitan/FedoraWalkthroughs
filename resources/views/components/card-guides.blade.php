@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $guide['titulo'] }}</h3>
    </div>
    <h5 class="mb-2 text-xl font-medium leading-tight">Autor: {{ $guide['usuario']['nombre'] }}</h5>
    @if (!empty($guide['puntuacion_media']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Puntuación Media: {{ $guide['puntuacion_media'] }}</h5>
    @endif
    <h5 class="mb-2 text-xl font-medium leading-tight">Aprobada: {{ $guide['aprobada'] }}</h5>
    <h5 class="mb-2 text-xl font-medium leading-tight">Idioma: {{ $guide['idioma']['nombre']}}</h5>
    @if (!empty($guide['lanzamiento']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Vídeojuego: {{ $guide['lanzamiento']['nombre'] }}</h5>
    @endif
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @if (Route::currentRouteName() !== 'guide.index')
                <h4 class="mb-2 text-2xl font-medium leading-tight">Secciones de la guía</h4>
                <!--<a href="{{ route('content.create', ['guide' => $guide['id']]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear
                </a>-->
                <form action="{{ route('content.create') }}" method="GET">
                    @csrf
                    <input type="hidden" name="guia_id" value="{{ $guide['id'] }}">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Añadir
                    </button>
                </form>
            @endif
        </div>
        @if (!empty($guide['contenidos']))
            <ul class="list-disc ml-6">
                @foreach ($guide['contenidos'] as $contenido)
                    <li>
                        <p class="font-bold">Nombre: {{ $contenido['nombre'] }}</p>
                        <p class="font-bold">Contenido: {!! nl2br(e($contenido['contenido'])) !!}</p>
                        <div class="flex gap-2 mx-2">
                            <!--<a href="{{route('content.edit', ['content' => $contenido['id']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>-->
                            <form action="{{route('content.edit', ['content' => $contenido['id']])}}" method="GET">
                                @csrf
                                <input type="hidden" name="guia_id" value="{{ $guide['id'] }}">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                            </form>
                            <form action="{{route('content.destroy', ['content' => $contenido['id']])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'guide.index')
            <a href="{{route('guide.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'guide.show')
            <a href="{{route('guide.show', ['guide' => $guide['id']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        <a href="{{route('guide.edit', ['guide' => $guide['id']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{route('guide.destroy', ['guide' => $guide['id']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>