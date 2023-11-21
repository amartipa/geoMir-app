@extends('layouts.app')

@section("header")
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Places') }}
    </h2>
@endsection

@section("content")
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <!-- Agrega más columnas según sea necesario -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destroy</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Favorite</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Favorites</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->description }}</td>
                            <!-- Agrega más filas según sea necesario -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('places.edit', $place) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">Edit</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('places.destroy', ['place' => $place->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('places.favorite', ['place' => $place->id]) }}" method="POST">
                                    @csrf
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Agregar a favoritos</button>
                                </form>
                                
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->favorited_count }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
