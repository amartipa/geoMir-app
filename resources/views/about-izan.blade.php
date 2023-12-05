@extends('layouts.app')

@section("header")
    <h2 class="font-bold text-3xl text-center text-gray-800 dark:text-gray-200 leading-tight mb-4">
        {{ __('About Us') }}
    </h2>
@endsection

@section("content")
    <style>
        .image-container {
            position: relative;
            width: 25rem;
            height: 25rem;
            overflow: hidden;
            cursor: pointer;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .image-container img:first-child {
            filter: grayscale(100%) contrast(150%);
        }

        .image-container:hover img:first-child {
            transform: rotateY(180deg);
        }

        .image-container img:last-child {
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

        .image-container:hover img:last-child {
            opacity: 1;
            transform: rotateY(0deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageContainer = document.querySelector('.image-container');
            const audioElement = new Audio("{{ asset('img/amadorSonido.mp3') }}");

            imageContainer.addEventListener('mouseenter', function () {
                audioElement.play();
            });

            imageContainer.addEventListener('mouseleave', function () {
                audioElement.pause();
                audioElement.currentTime = 0;
            });

            const modal = document.getElementById('video-modal');
            const modalButton = document.getElementById('modal-button');
            const modalCloseButton = document.getElementById('modal-close-button');

            modalButton.addEventListener('click', function () {
                modal.classList.toggle('hidden');
            });

            modalCloseButton.addEventListener('click', function () {
                modal.classList.toggle('hidden');
            });
        });
    </script>

    <div class="flex flex-col items-center mt-8">
        <div class="flex items-center justify-center mb-8">
            <div class="image-container" id="modal-button">
                <img src="{{ asset('img/amadorSerio.png') }}">
                <img src="{{ asset('img/amador.png') }}">
            </div>
        </div>

        <div class="text-center">
            <h3 class="text-xl font-bold mb-2">Izan Gonzalvez Aranda</h3>
            <p class="text-gray-600">Web developer</p>
        </div>
    </div>

    <div id="video-modal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white p-8 rounded shadow-md">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/U7rejTPRba0?si=1-W-6u3w5M5Ex3wB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>                <button id="modal-close-button" class="mt-4 p-2 bg-gray-700 text-white rounded">Close</button>
            </div>
        </div>
    </div>
@endsection
