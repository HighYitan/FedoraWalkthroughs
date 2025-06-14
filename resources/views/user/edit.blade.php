<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Usuario') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.update', ['user' => $user['correo'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre">Nombre de usuario</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre') border-color:RED; @enderror" value="{{ $user['nombre'] }}" name="nombre" />
                            @foreach ($errors->get('nombre') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" class="mt-1 block w-full" style="@error('correo') border-color:RED; @enderror" value="{{ $user['correo'] }}" name="correo" />
                            @foreach ($errors->get('correo') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="contraseña">Contraseña</label>
                            <input type="password" class="mt-1 block w-full" style="@error('contraseña') border-color:RED; @enderror" name="contraseña" />
                            @foreach ($errors->get('contraseña') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="baneado">Baneado</label>
                            <select name="baneado" class="mt-1 block w-full">
                                <option value="N">No</option>
                                <option value="Y" {{ $user['baneado'] == 'Sí' ? 'selected' : '' }}>Sí</option>
                            </select>
                            @foreach ($errors->get('baneado') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="rol">Rol</label>
                            <select name="rol" class="mt-1 block w-full mb-1">
                                @foreach ($roles as $role)
                                    <option value="{{ $role['rol'] }}" {{ ($user['rol'] == $role['rol']) ? 'selected' : '' }}>{{ $role['rol'] }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('rol') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{route('user.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>