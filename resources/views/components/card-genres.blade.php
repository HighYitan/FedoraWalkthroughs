@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $genre['nombre_inicial'] }}</h3>
    </div>
    <div class="mb-8">
        @if (!empty($genre['traducciones']))
            <ul class="list-disc ml-6">
                @foreach ($genre['traducciones'] as $traduccion)
                    <li>
                        <p class="font-bold">Idioma: {{ $traduccion['idioma']['nombre'] }}</p>
                        <p class="font-bold">Nombre: {{ $traduccion['nombre'] }}</p>
                        <p class="font-bold">Descripción: {!! nl2br(e($traduccion['descripcion'])) !!}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'genre.index')
            <a href="{{route('genre.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'genre.show')
            <a href="{{route('genre.show', ['genre' => $genre['nombre_inicial']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        <a href="{{route('genre.edit', ['genre' => $genre['nombre_inicial']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{route('genre.destroy', ['genre' => $genre['nombre_inicial']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>