<x-geomir-layout>
    <div class="bg-gradient-to-r from-purple-600 via-blue-500 to-green-400 text-white py-12">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-4">¡Bienvenido a GeoMir!</h1>
            <p class="text-lg mb-8">
                Descubre lugares fascinantes, comparte tus experiencias y conecta con el mundo a través de GeoMir.
            </p>
        </div>
    </div>

    <div class="container mx-auto my-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Bloque de Posts -->
            <div class="bg-purple-200 p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-bold mb-4">Posts</h2>
                <p class="text-gray-700">
                    Crea publicaciones compartiendo imágenes y descripciones para que otros descubran tus experiencias.
                </p>
            </div>

            <!-- Bloque de Place -->
            <div class="bg-blue-200 p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-bold mb-4">Place</h2>
                <p class="text-gray-700">
                    Sube mapas con coordenadas y descripciones para marcar lugares especiales en tu vida.
                </p>
            </div>

            <!-- Bloque de Amistades -->
            <div class="bg-green-200 p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-bold mb-4">Amistades</h2>
                <p class="text-gray-700">
                    Descubre y conecta con amigos y personas afines a través de nuestra comunidad Geomir.
                </p>
            </div>

            <!-- Bloque de Perfil -->
            <div class="bg-yellow-200 p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-bold mb-4">Perfil</h2>
                <p class="text-gray-700">
                    Personaliza tu perfil agregando información sobre ti, incluyendo datos y tu foto.
                </p>
            </div>

            <!-- Bloque de Interactúa -->
            <div class="bg-orange-200 p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-bold mb-4">Interactúa</h2>
                <p class="text-gray-700">
                    Dale like y marca como favoritos los posts que te gusten, interactúa con la comunidad GeoMir.
                </p>
            </div>

            <!-- Bloque de Seguridad -->
            <div class="bg-red-200 p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-bold mb-4">Seguridad</h2>
                <p class="text-gray-700">
                    GeoMir garantiza la seguridad de tus datos y experiencias, brindándote una experiencia confiable.
                </p>
            </div>
        </div>
    </div>
    <div class="container mx-auto my-8 text-center">
        <h2 class="text-4xl font-bold mb-6">Así se muestra nuestra aplicación</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Bloque de Posts -->
            <div class="bg-beige-200 p-6 rounded-md shadow-md mb-8">
                <h2 class="text-3xl font-bold mb-4">Posts</h2>

                <!-- Ejemplo de Post -->
                <div class="flex items-center mb-4">
                    <img src="{{ asset('img/perfil.png') }}" alt="Logo" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="text-lg font-bold">BacalaoConSanfaina</h3>
                        <p class="text-gray-600">Un día con Doraemon</p>
                    </div>
                </div>

                <p class="text-gray-700 mb-4">
                    Disfruté de un día increíble con Doraemon, explorando lugares mágicos y llenos de diversión. ¡Aquí está la foto de nuestro emocionante día!
                </p>

                <img src="{{ asset('img/amador.png') }}" alt="Ejemplo de Foto" class="w-full h-48 object-cover mb-4">
            </div>

            <!-- Bloque de Places -->
            <div class="bg-beige-200 p-6 rounded-md shadow-md mb-8">
                <h2 class="text-3xl font-bold mb-4">Places</h2>

                <!-- Ejemplo de Place -->
                <div class="flex items-center mb-4">
                    <img src="{{ asset('img/perfil.png') }}" alt="Logo" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="text-lg font-bold">BacalaoConSanfaina</h3>
                        <p class="text-gray-600">Parque Mágico</p>
                    </div>
                </div>

                <p class="text-gray-700 mb-4">
                    40.7128° N, 74.0060° W.
                </p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001.0683431806656!2d1.7281913754334293!3d41.22028110634482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a386e65f8da661%3A0xd7ee23c0750d9d3b!2sVilanova%20I%20La%20Geltr%C3%BA!5e0!3m2!1ses-419!2ses!4v1701797590553!5m2!1ses-419!2ses" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                <p class="text-gray-700 mb-4">
                    Descubrí un lugar mágico, el Parque Mágico, lleno de alegría y belleza.
                </p>
            </div>
        </div>
    </div>
</x-geomir-layout>