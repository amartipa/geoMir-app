@extends('layouts.app')
    @section("header")
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Posts') }}
    </h2>
    @endsection
   
   @section("content")
   <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @can('create',App\Models\Post::class)
            <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"href="{{ url('/posts/create') }}">{{ __('Create') }}</a>
        @endcan
            <a href="{{ url('/dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">{{ __('Dashboard') }}</a>
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
               <div class="p-6 bg-white border-b border-gray-200">
                   
               <table class="table">
                      <thead>
                          <tr class="border-b dark:border-neutral-500">
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{__('Description')}}</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{__('Photo')}}</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{__('Latitude')}}</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{__('Longitude')}}</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">Like</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">view</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">Delete</td>
                              <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" scope="col">Edit</td> 
                          </tr>
                      </thead>
                      <tbody class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
                            @csrf
                            <div class="flex">
                                <input type="text" name="search" placeholder="Buscar en el cuerpo del post" class="form-input flex-grow mr-2" />
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Buscar</button>
                            </div>
                        </form>
                          @foreach ($posts as $post)
                          <tr class="border-b dark:border-neutral-500">
                              <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
                              <td class="px-6 py-4 whitespace-nowrap">{{ $post->body }}</td>
                              <td class="px-6 py-4 whitespace-nowrap"><img class="img-fluid" src='{{ asset("storage/{$post->file->filepath}") }}' /></td>
                              <td class="px-6 py-4 whitespace-nowrap">{{ $post->latitude }}</td>
                              <td class="px-6 py-4 whitespace-nowrap">{{ $post->longitude }}</td>
                              @can('like',$post)
                                <td class="px-6 py-4 whitespace-nowrap"><form action="{{ route('posts.like', ['post' => $post->id]) }}" method="post">
                                @csrf
                                @method('POST')
                                    <p></p>
                                    @if($post->isLiked)
                                        <button type="submit"><i class="fa-solid fa-heart" style="color: #ff0000;"></i> {{$post->liked_count}}</button>
                                    @else
                                        <button type="submit"> <i class="fa-regular fa-heart"></i> {{$post->liked_count}}</button>
                                    @endif
                               </form> 
                               @endcan
                              @can('view',$post)                             
                                <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('posts.show', ['post' => $post->id]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">{{__('View')}}</a></td>
                              @endcan
                              @can('delete',$post)
                                <td class="px-6 py-4 whitespace-nowrap"><form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"><i class="fas fa-trash"></i></button>
                                </form>
                                </td>
                            @endcan
                            @can('update',$post)
                                <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('posts.edit', $post) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">Editar</a>
                                </tr>
                            @endcan
                          @endforeach
                          {{$posts->links()}}
                      </tbody>
                  </table>
               </div>
           </div>
       </div>
   </div>
   
@endsection



