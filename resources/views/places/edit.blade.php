<script src="https://cdn.tailwindcss.com"></script>
<form method="post" action="{{ route('places.update', $place) }}" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md">
    @csrf
    @method('PUT')
    
    <div class="mb-4">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Descripción:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <label for="latitude">Latitud:</label>
        <input type="number" id="latitude" name="latitude" step="any" required><br><br>

        <label for="longitude">Longitud:</label>
        <input type="number" id="longitude" name="longitude" step="any" required><br><br>

        <label for="visibility_id">{{__('Visibility')}}</label><br>
        <select id="visibility_id" name="visibility_id" class="form-input w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="1" {{$place->visibility_id == 1 ? 'selected' : ''}}>Public</option>
            <option value="2" {{$place->visibility_id == 2 ? 'selected' : ''}}>Contacts</option>
            <option value="2" {{$place->visibility_id == 3 ? 'selected' : ''}}>Private</option>
           
        </select><br>

        <label for="upload">file:</label>
        <input type="file" id="upload" name="upload" required><br><br>
    </div>
    <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Edit</button>
    </div>
</form>
<img class="mt-4 mx-auto max-w-md" src='{{ asset("storage/{$place->file->filepath}") }}' />
<a href="{{ url('/dashboard') }}" class="block mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg mx-auto">{{ __('Dashboard') }}</a>