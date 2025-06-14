@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $company['nombre'] }}</h3>
    </div>
    @if (isset($company['fundacion']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Año de fundación: {{ $company['fundacion'] }}</h5>
    @endif
    <h5 class="mb-2 text-xl font-medium leading-tight">País de origen: {{ $company['pais'] }}</h5>
    @if (isset($company['web']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Página web: {{ $company['web'] }}</h5>
    @endif
    @if (isset($company['imagen']))
        <h5 class="mb-2 text-xl font-medium leading-tight">Imagen: {{ $company['imagen'] }}</h5>
    @endif
    @if (!empty($company['plataformas']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Plataformas</h4>
            <ul class="list-disc ml-6">
                @foreach ($company['plataformas'] as $plataforma)
                    <li>
                        <p class="font-bold">Plataforma: {{ $plataforma['nombre'] }}</p>
                        <p class="font-bold">Año de salida: {{ $plataforma['lanzamiento'] }}</p>
                        <p class="font-bold">Imagen: {{ $plataforma['imagen'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($company['desarrollaron']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Desarrollaron</h4>
            <ul class="list-disc ml-6">
                @foreach ($company['desarrollaron'] as $desarrollaron)
                    <li>
                        <p class="font-bold">Título del lanzamiento: {{ $desarrollaron['nombre'] }}</p>
                        <p class="font-bold">Fecha del lanzamiento: {{ $desarrollaron['lanzamiento'] }}</p>
                        <p class="font-bold">Región: {{ $desarrollaron['region']['nombre_inicial'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($company['distribuyeron']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Distribuyeron</h4>
            <ul class="list-disc ml-6">
                @foreach ($company['distribuyeron'] as $distribuyeron)
                    <li>
                        <p class="font-bold">Título del lanzamiento: {{ $distribuyeron['nombre'] }}</p>
                        <p class="font-bold">Fecha del lanzamiento: {{ $distribuyeron['lanzamiento'] }}</p>
                        <p class="font-bold">Región: {{ $distribuyeron['region']['nombre_inicial'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'company.index')
            <a href="{{route('company.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'company.show')
            <a href="{{route('company.show', ['company' => $company['nombre']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        <a href="{{route('company.edit', ['company' => $company['nombre']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{route('company.destroy', ['company' => $company['nombre']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>