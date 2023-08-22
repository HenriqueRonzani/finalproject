<link rel="stylesheet" href="{{ asset('css/my.css') }}">


<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>



    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8" >
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($posts as $post)
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

                        <pre class=" text-sm overflow-auto max-w-5xl">
                            <x-torchlight-code language="{{$post->type->name}}">
                                {!! $post->message !!}
                            </x-torchlight-code>
                        </pre>

                        <div class="flex justify-start">


                            <form method="get" class="flex justify-start" action= "{{ route('like.toggle', ['post' => $post])}}">

                            @if ($post->hasLiked($post))

                            <button type="submit">
                                <img class="mx-2 w-7" src="{{ asset('img/liked.png') }}">
                            </button>

                            @else

                            <button type="submit">
                                <img class="mx-2 w-7" src="{{ asset('img/not-liked.png') }}">
                            </button>

                            @endif

                            </form>

                            <a href="{{ route('comments.index', ['posts' => $post->id])}}">
                                <img class="mx-2 w-7" src="{{ asset('img/comment.png')}}">
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
