<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Compañía') }}
            </h2>
            <a href="{{ route('company.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Añadir
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('company.update', ['company' => $company['nombre'] ]) }}" method="post">
                        @csrf  <!-- Security Token -->
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre">Nombre de la compañía</label>
                            <input type="text" class="mt-1 block w-full" style="@error('nombre') border-color:RED; @enderror" value="{{ $company['nombre'] }}" name="nombre" />
                            @foreach ($errors->get('nombre') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="fundacion">Año de fundación</label>
                            <input type="number" class="mt-1 block w-full" style="@error('fundacion') border-color:RED; @enderror" value="{{ $company['fundacion'] }}" name="fundacion" min="1880" max="{{ date('Y') }}" />
                            @foreach ($errors->get('fundacion') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="pais">País de origen</label>
                            <select name="pais" class="mt-1 block w-full mb-1">
                                @foreach ($languages as $language)
                                    <option value="{{ $language['abreviatura'] }}" {{ ($company['pais'] == $language['abreviatura']) ? 'selected' : '' }}>{{ $language['abreviatura'] }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('pais') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="web">Página web</label>
                            <input type="url" class="mt-1 block w-full" style="@error('web') border-color:RED; @enderror" value="{{ $company['web'] }}" name="web" />
                            @foreach ($errors->get('web') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Imagen</label>
                            <input type="url" class="mt-1 block w-full" style="@error('imagen') border-color:RED; @enderror" value="{{ $company['imagen'] }}" name="imagen" />
                            @foreach ($errors->get('imagen') as $message)
                                <div class="text-red-500">{{$message}}</div>
                            @endforeach
                        </div>
                        <div>
                            <a href="{{route('company.index')}}" class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>