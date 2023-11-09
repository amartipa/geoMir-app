@extends('layouts.app')

    @section("header")
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    @endsection

    @section("content")
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    
                    
                  
                </div>
                <h2>{{ __('Resources') }}</h2><br>
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/files') }}">{{ __('Files') }}</a>
                    <br><br>
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/files/create') }}">{{ __('Create files') }}</a>
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/posts') }}">{{ __('Posts') }}</a>
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/files/create') }}">{{ __('Create') }}</a>
                    <br><br>
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" href="{{ url('/places') }}">{{ __('Place') }}</a>
            </div>
        </div>
    </div>
    @endsection

