@extends('layouts.app')

@section("header")
    <h2 class="font-bold text-3xl text-center text-gray-800 dark:text-gray-200 leading-tight mb-4">
        {{ __('About Us') }}
    </h2>
@endsection

@section("content")
    <!-- Estilos e scripts para Izan -->
    <style>
        .izan-image-container {
            position: relative;
            width: 25rem;
            height: 25rem;
            overflow: hidden;
            cursor: pointer;
        }

        .izan-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .izan-image-container img:first-child {
            filter: grayscale(100%) contrast(150%);
        }

        .izan-image-container:hover img:first-child {
            transform: rotateY(180deg);
        }

        .izan-image-container img:last-child {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: rotateY(180deg);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .izan-image-container:hover img:last-child {
            opacity: 1;
            transform: rotateY(0deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const izanImageContainer = document.querySelector('.izan-image-container');
            const izanAudioElement = new Audio("{{ asset('img/amadorSonido.mp3') }}");

            izanImageContainer.addEventListener('mouseenter', function () {
                izanAudioElement.play();
            });

            izanImageContainer.addEventListener('mouseleave', function () {
                izanAudioElement.pause();
                izanAudioElement.currentTime = 0;
            });

            const izanModal = document.getElementById('izan-video-modal');
            const izanModalButton = document.getElementById('izan-modal-button');
            const izanModalCloseButton = document.getElementById('izan-modal-close-button');

            izanModalButton.addEventListener('click', function () {
                izanModal.classList.toggle('hidden');
            });

            izanModalCloseButton.addEventListener('click', function () {
                izanModal.classList.toggle('hidden');
            });
        });
    </script>

     <!-- Estilos e scripts para Adria -->
     <style>
        .adria-image-container {
            position: relative;
            width: 25rem;
            height: 25rem;
            overflow: hidden;
            cursor: pointer;
        }

        .adria-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .adria-image-container img:first-child {
            filter: grayscale(100%) contrast(150%);
        }

        .adria-image-container:hover img:first-child {
            transform: rotateX(180deg);
        }

        .adria-image-container img:last-child {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: rotateX(180deg);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .adria-image-container:hover img:last-child {
            opacity: 1;
            transform: rotateX(0deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const adriaImageContainer = document.querySelector('.adria-image-container');
            const adriaAudioElement = new Audio("{{ asset('img/paco.mp3') }}");

            adriaImageContainer.addEventListener('mouseenter', function () {
                adriaAudioElement.play();
            });

            adriaImageContainer.addEventListener('mouseleave', function () {
                adriaAudioElement.pause();
                adriaAudioElement.currentTime = 0;
            });

            const adriaModal = document.getElementById('adria-video-modal');
            const adriaModalButton = document.getElementById('adria-modal-button');
            const adriaModalCloseButton = document.getElementById('adria-modal-close-button');

            adriaModalButton.addEventListener('click', function () {
                adriaModal.classList.toggle('hidden');
            });

            adriaModalCloseButton.addEventListener('click', function () {
                adriaModal.classList.toggle('hidden');
            });
        });
    </script>
    <div class="flex flex-row items-center justify-center">
        <!-- Contenido de Izan -->
        <div class="flex flex-col items-center mt-8">
            <div class="flex items-center justify-center mb-8">
                <div class="izan-image-container" id="izan-modal-button">
                    <img src="{{ asset('img/amadorSerio.png') }}">
                    <img src="{{ asset('img/amador.png') }}">
                </div>
            </div>

            <div class="text-center">
                <h3 class="text-xl font-bold mb-2">Izan Gonzalvez Aranda</h3>
                <p class="text-gray-600">Web developer</p>
            </div>
        </div>

        <div id="izan-video-modal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75">
            <div class="flex items-center justify-center h-full">
                <div class="bg-white p-8 rounded shadow-md">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/U7rejTPRba0?si=1-W-6u3w5M5Ex3wB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <button id="izan-modal-close-button" class="mt-4 p-2 bg-gray-700 text-white rounded">Close</button>
                </div>
            </div>
        </div>

        <!-- Contenido de Adria -->

        <div class="flex flex-col items-center mt-8">
            <div class="flex items-center justify-center mb-8">
                <div class="adria-image-container" id="adria-modal-button">
                    <img src="{{ asset('img/images.png') }}">
                    <img src="{{ asset('img/images2.png') }}">
                </div>
            </div>

            <div class="text-center">
                <h3 class="text-xl font-bold mb-2">Adria Martinez Paredes</h3>
                <p class="text-gray-600">Web developer</p>
            </div>
        </div>

        <div id="adria-video-modal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75">
            <div class="flex items-center justify-center h-full">
                <div class="bg-white p-8 rounded shadow-md">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/7lQfj-_8Zg0?si=PrMwqi1XKBAHGHC_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <button id="adria-modal-close-button" class="mt-4 p-2 bg-gray-700 text-white rounded">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection