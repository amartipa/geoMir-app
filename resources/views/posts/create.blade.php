
<script src="https://cdn.tailwindcss.com"></script>
<form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md">
    @csrf
    
    <label for="body">Descripción:</label><br>
    <textarea id="body" name="body" rows="4" cols="50" placeholder="Ingresa tu texto aquí..."></textarea><br>

    <label for="latitude">Latitud:</label><br>
    <input type="number" id="latitude" name="latitude" step="0.000001" placeholder="Ejemplo: -34.603722"><br>

    <label for="longitude">Longitud:</label><br>
    <input type="number" id="longitude" name="longitude" step="0.000001" placeholder="Ejemplo: -58.381592"><br>

    <div class="mb-4">
        <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">File:</label>
        <input type="file" name="upload" class="form-input w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
    </div>
    <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Create</button>
        <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Reset</button>
    </div>
</form>
<a href="{{ url('/dashboard') }}" class="block mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg mx-auto">{{ __('Dashboard') }}</a>