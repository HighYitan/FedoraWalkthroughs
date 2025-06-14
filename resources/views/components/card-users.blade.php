@php use Illuminate\Support\Facades\Route; @endphp
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-4xl font-medium leading-tight">{{ $user['nombre'] }}</h3>
    </div>
    <h5 class="mb-2 text-xl font-medium leading-tight">Correo Electrónico: {{ $user['correo'] }}</h5>
    <h5 class="mb-2 text-xl font-medium leading-tight">Rol: {{ $user['rol'] }}</h5>
    <h5 class="mb-2 text-xl font-medium leading-tight">Baneado: {{ $user['baneado'] }}</h5>
    @if (!empty($user['foros']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Foros</h4>
            <ul class="list-disc ml-6">
                @foreach ($user['foros'] as $foro)
                    <li>
                        <p class="font-bold">Título: {{ $foro['titulo'] }}</p>
                        <p class="font-bold">Descripción: {{ $foro['descripcion'] }}</p>
                        <p class="font-bold">Lanzamiento: {{ $foro['lanzamiento']['nombre'] }}</p>
                        <p class="font-bold">Idioma: {{ $foro['idioma']['nombre'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($user['guias']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Guías</h4>
            <ul class="list-disc ml-6">
                @foreach ($user['guias'] as $guia)
                    <li>
                        <p class="font-bold">Título: {{ $guia['titulo'] }}</p>
                        <p class="font-bold">Lanzamiento: {{ $guia['lanzamiento']['nombre'] }}</p>
                        <p class="font-bold">Idioma: {{ $guia['idioma']['nombre'] }}</p>
                        <p class="font-bold">Aprobada: {{ $guia['aprobada'] }}</p>
                        @if (!empty($guia['puntuacion_media']))
                            <p class="font-bold">Puntuación Media: {{ $guia['puntuacion_media'] }}</h5>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($user['comentarios_foros']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Comentarios en foros</h4>
            <ul class="list-disc ml-6">
                @foreach ($user['comentarios_foros'] as $comentarioForo)
                    <li>
                        <p class="font-bold">Título del tema: {{ $comentarioForo['foro']['titulo'] }}</p>
                        <p class="font-bold">Lanzamiento del foro: {{ $comentarioForo['foro']['lanzamiento']['nombre'] }}</p>
                        <p class="font-bold">Comentario: {{ $comentarioForo['comentario'] }}</p>
                        @if (!empty($comentarioForo['imagenes']))
                            <h4 class="mb-2 text-xl font-medium leading-tight">Imágenes</h4>
                            @foreach ($comentarioForo['imagenes'] as $imagen)
                                <p class="font-bold">Imagen: {{ $imagen['foto'] }}</h5>
                            @endforeach
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($user['puntuaciones_juegos']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Puntuaciones a Juegos</h4>
            <ul class="list-disc ml-6">
                @foreach ($user['puntuaciones_juegos'] as $puntuacionJuego)
                    <li>
                        <p class="font-bold">Videojuego: {{ $puntuacionJuego['videojuego']['nombre_inicial'] }}</p>
                        <p class="font-bold">Puntuación: {{ $puntuacionJuego['puntuacion'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($user['puntuaciones_guias']))
        <div class="mb-4">
            <h4 class="mb-2 text-2xl font-medium leading-tight">Puntuaciones a Guías</h4>
            <ul class="list-disc ml-6">
                @foreach ($user['puntuaciones_guias'] as $puntuacionGuia)
                    <li>
                        <p class="font-bold">Guía: {{ $puntuacionGuia['guia']['titulo'] }}</p>
                        <p class="font-bold">Puntuación: {{ $puntuacionGuia['puntuacion'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex gap-2 mt-4">
        @if (Route::currentRouteName() !== 'user.index')
            <a href="{{route('user.index')}}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
        @endif
        @if (Route::currentRouteName() !== 'user.show')
            <a href="{{route('user.show', ['user' => $user['correo']])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mostrar</a>
        @endif
        <a href="{{route('user.edit', ['user' => $user['correo']])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{route('user.destroy', ['user' => $user['correo']])}}" method="POST" class="ml-auto">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
        </form>
    </div>
</div>