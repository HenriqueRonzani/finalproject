<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<x-app-layout>

    <x-slot name="header">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Comentários') }}
        </h2>
    </x-slot>


    <div class="max-w-6xl mx-auto p-3 sm:px-6 lg:px-8">
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <div class="p-6 flex space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>

                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $post->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('d/m/y, H:i') }}</small>
                        </div>
                    </div>

                    <p class="text-gray-800 text-2xl">{{ $post->title }}</p>

                    <pre class="min-w-0 text-sm overflow-auto max-w-5xl">
                        <x-torchlight-code language="{{$post->type->name}}">
                            {!! $post->message !!}
                        </x-torchlight-code>
                    </pre>



                </div>

            </div>


                <form method="POST" action="{{ route('comments.store', ['post' => $post->id]) }}">

                    @csrf
                    <p class="py-4 text-gray-800 text-3xl text-center">
                        {{ __('Adicionar Comentário')}}
                    </p>

                    <textarea
                    rows="5"
                    name="message"
                    placeholder="{{ __('Digite seu comentário') }}"
                    class=" mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >{{ old('message') }}</textarea>

                    <x-input-error :messages="$errors->get('message')" class="mt-2" />

                <div class="flex justify-center">
                <x-primary-button class=" mx-auto my-4 h-10" >{{ __('Publicar') }}</x-primary-button>
                </div>


        </div>
    </div>


    @foreach ($post->comment as $comments)

    <div class="max-w-6xl mx-auto py-1 sm:px-6 lg:px-8" >
        <div class=" bg-white shadow-sm rounded-lg divide-y">
            <div class="p-6 flex space-x-2">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>

                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $comments->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $comments->created_at->format('d/m/y, H:i') }}</small>

                        </div>
                    </div>
                    <p class="mt-4 text-lg text-gray-900">{{ $comments->message }}</p>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</x-app-layout>
