@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $news['titulo_inicial'] }}</h3>
    </div>
    <div class="mb-8">
        @if (!empty($news['traducciones']))
            <ul class="list-disc ml-6">
                @foreach ($news['traducciones'] as $traduccion)
                    <li>
                        <p class="font-bold">Idioma: {{ $traduccion['idioma']['nombre'] }}</p>
                        <p class="font-bold">Título: {{ $traduccion['titulo'] }}</p>
                        <p class="font-bold">Contenido: {!! nl2br(e($traduccion['contenido'])) !!}</p>
                        <p class="font-bold">Imagen: {{ $traduccion['imagen'] }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'news.index')
            <a href="{{route('news.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'news.show')
            <a href="{{route('news.show', ['news' => $news['titulo_inicial']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        <a href="{{route('news.edit', ['news' => $news['titulo_inicial']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{route('news.destroy', ['news' => $news['titulo_inicial']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>