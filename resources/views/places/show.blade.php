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
                            <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</td>
                            <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</td>
                            <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</td>
                            <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</td>
                            <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</td>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destroy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->latitude }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $place->longitude }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><img class="img-fluid" src="{{ asset("storage/{$place->file->filepath}") }}" /></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('places.destroy', ['place' => $place->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('places.edit', $place) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">Editar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection