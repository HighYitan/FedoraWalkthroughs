@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $platform['nombre'] }}</h3>
    </div>
    <h5 class="mb-2 text-xl font-medium leading-tight">Año de lanzamiento: {{ $platform['lanzamiento'] }}</h5>
    <h5 class="mb-2 text-xl font-medium leading-tight">Desarrollador: {{ $platform['desarrollador']['nombre'] }}</h5>
    @if (isset($platform['imagen']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Imagen: {{ $platform['imagen'] }}</h5>
    @endif
    @if (!empty($platform['lanzamientos']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Lanzamientos de videojuegos</h4>
            <ul class="list-disc ml-6">
                @foreach ($platform['lanzamientos'] as $lanzamiento)
                    <li>
                        <p class="font-bold">Nombre: {{ $lanzamiento['nombre'] }}</p>
                        <p class="font-bold">Fecha de lanzamiento: {{ $lanzamiento['lanzamiento'] }}</p>
                        <p class="font-bold">Región: {{ $lanzamiento['region']['nombre_inicial'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'platform.index')
            <a href="{{route('platform.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'platform.show')
            <a href="{{route('platform.show', ['platform' => $platform['nombre']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        <a href="{{route('platform.edit', ['platform' => $platform['nombre']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{route('platform.destroy', ['platform' => $platform['nombre']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>