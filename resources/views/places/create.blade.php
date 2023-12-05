<script src="https://cdn.tailwindcss.com"></script>
<form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md">
    @csrf
    
    <div class="mb-4">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Descripción:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <label for="latitude">Latitud:</label>
        <input type="number" id="latitude" name="latitude" step="any" required><br><br>

        <label for="longitude">Longitud:</label>
        <input type="number" id="longitude" name="longitude" step="any" required><br><br>

        <label for="visibility_id">{{__('Visibility')}}:</label><br>
        <select id="visibility_id" name="visibility_id" class="form-input w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <option value="1">Public</option>
        <option value="2">Contacts</option>
        <option value="3">Private</option>
        
    </select><br>

        <label for="upload">file:</label>
        <input type="file" id="upload" name="upload" required><br><br>
    </div>
    <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Create</button>
        <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Reset</button>
    </div>
</form>
<a href="{{ url('/dashboard') }}" class="block mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg mx-auto">{{ __('Dashboard') }}</a>