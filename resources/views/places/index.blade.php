@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Places') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/places/create') }}">{{ __('Create') }}</a>
            <a href="{{ url('/dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">{{ __('Dashboard') }}</a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                            <tr class="border-b dark:border-neutral-500">
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Favortites</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">Delete</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">Edit</td>
                            </tr>
                        </thead>
                        <tbody class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <form action="{{ route('places.index') }}" method="GET" class="mb-4">
                                @csrf
                                <div class="flex">
                                    <input type="text" name="search" placeholder="Buscar en el cuerpo del post" class="form-input flex-grow mr-2" />
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Buscar</button>
                                </div>
                            </form>
                            @foreach ($places as $place)
                                @if($place->visibility_id == 1 || ($place->visibility_id == 3 && $place->user->is(auth()->user())))
                                <tr class="border-b dark:border-neutral-500">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $place->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $place->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $place->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $place->latitude }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $place->longitude }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    @can('favorite',$place)
                                        <form action="{{ route('places.favorite', ['place' => $place->id]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="flex items-center">
                                                @if($place->favorited_count > 0)
                                                    <i class="fa-solid fa-star text-yellow-500 mr-2"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-gray-500 mr-2"></i>
                                                @endif
                                                <span>{{ $place->favorited_count }}</span>
                                            </button>
                                        </form>
                                    @endcan
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><img class="img-fluid" src="{{ asset("storage/{$place->file->filepath}") }}" /></td>
                                    @can('delete',$place)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('places.destroy', ['place' => $place->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    @endcan
                                    @can('update',$place)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('places.edit', $place) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">Editar</a>
                                    </td>
                                    @endcan
                                </tr>
                            @endif
                            @endforeach
                            {{ $places->links() }}
                        </tbody>
                    </table>
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Places') }}
                </h2>
                <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/places/create') }}">{{ __('Create') }}</a>
            </div>

            <form action="{{ route('places.index') }}" method="GET" class="mb-4">
                @csrf
                <div class="flex">
                    <input type="text" name="search" placeholder="Buscar en el cuerpo del post" class="form-input flex-grow mr-2" />
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Buscar</button>
                </div>
            </form>

            @foreach ($places as $place)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                    <div class="mb-4">
                        <p class="text-lg font-semibold">ID: {{ $place->id }}</p>
                        <p class="text-xl">{{ $place->name }}</p>
                        <p>Longitude: {{ $place->longitude }} | Latitude: {{ $place->latitude }}</p>
                    </div>

                    <div class="mb-4">
                        <img class="img-fluid max-w-xs" src="{{ asset("storage/{$place->file->filepath}") }}" />
                    </div>

                    <div class="mb-4">
                        <p>{{ $place->description }}</p>
                    </div>

                    <div class="flex justify-between items-end">
                        <div class="text-left">
                            @can('favorite', $place)
                                <form action="{{ route('places.favorite', ['place' => $place->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="flex items-center">
                                        @if($place->favorited_count > 0)
                                            <i class="fa-solid fa-star text-yellow-500 mr-2"></i>
                                        @else
                                            <i class="fa-regular fa-star text-gray-500 mr-2"></i>
                                        @endif
                                        <span>{{ $place->favorited_count }}</span>
                                    </button>
                                </form>
                            @endcan
                        </div>

                        <div class="text-center">
                            @can('delete', $place)
                                <form action="{{ route('places.destroy', ['place' => $place->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>

                        <div class="text-right">
                            @can('update', $place)
                                <a href="{{ route('places.edit', $place) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">Edit</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('places.index') }}" method="GET" class="mb-4">
                @csrf
                <div class="flex">
                    <input type="text" name="search" placeholder="Buscar en el cuerpo del post" class="form-input flex-grow mr-2" />
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Buscar</button>
                </div>
            </form>

            @foreach ($places as $place)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                    <div class="mb-4">
                        <p class="text-lg font-semibold">ID: {{ $place->id }}</p>
                        <p class="text-xl">{{ $place->name }}</p>
                        <p>Longitude: {{ $place->longitude }} | Latitude: {{ $place->latitude }}</p>
                    </div>

                    <div class="mb-4">
                        <img class="img-fluid max-w-xs" src="{{ asset("storage/{$place->file->filepath}") }}" />
                    </div>

                    <div class="mb-4">
                        <p>{{ $place->description }}</p>
                    </div>

                    <div class="flex justify-between items-end">
                        <div class="text-left">
                            @can('favorite', $place)
                                <form action="{{ route('places.favorite', ['place' => $place->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="flex items-center">
                                        @if($place->favorited_count > 0)
                                            <i class="fa-solid fa-star text-yellow-500 mr-2"></i>
                                        @else
                                            <i class="fa-regular fa-star text-gray-500 mr-2"></i>
                                        @endif
                                        <span>{{ $place->favorited_count }}</span>
                                    </button>
                                </form>
                            @endcan
                        </div>

                        <div class="text-center">
                            @can('delete', $place)
                                <form action="{{ route('places.destroy', ['place' => $place->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>

                        <div class="text-right">
                            @can('update', $place)
                                <a href="{{ route('places.edit', $place) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">Edit</a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $places->links() }}
        </div>
    </div>
@endsection
